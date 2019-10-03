<?php

namespace App\Http\Controllers;

use Tmdb\Helper\ImageHelper;
use Tmdb\Repository\MovieRepository;
use Tmdb\Repository\DiscoverRepository;
use Tmdb\Model\Query\Discover\DiscoverMoviesQuery;
use Tmdb\Repository\GenreRepository;
use Tmdb\Model\Genre;

use App\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MoviesController extends Controller {

    private $movie;
    private $helper;
    private $discover;
    private $query;
    private $currentTime;
    private $genre;
    
    public function __construct(MovieRepository $movie, ImageHelper $helper, DiscoverRepository $discover, DiscoverMoviesQuery $query, GenreRepository $genre)
    {
        $this->movie = $movie;
        $this->helper = $helper;
        $this->discover = $discover;
        $this->currentTime = date("Y-m-d", time());
        $this->query = $query->page(1)->primaryReleaseDateGte($this->currentTime);
        $this->genre = $genre;
    }
    
    private function getGenreNameTMDB($id) {
        $genre = $this->genre->load($id);
//        dd($genre->getName());
        return $genre->getName();
    }
    
    private function getGenresTMDB($id) {
        $genres_ = array();
        $movie = $this->movie->load($id);
        $genres = $movie->getGenres();
        
            foreach($genres as $genreId){
                $genre = $this->getGenreNameTMDB($genreId->getId());
                $genres_[] = $genre;
            }
//            dd(implode(",", $genres_));
            return implode(",", $genres_);
    }
    
    private function getMoviesTMDB($pages) {
        
        $movies = array();
        $query = new \Tmdb\Model\Query\Discover\DiscoverMoviesQuery();

        for ($page = 1; $page <= $pages; $page++) {
            $movie = $this->discover->discoverMovies($query->page($page)->primaryReleaseDateGte($this->currentTime));
            $movies[] = $movie;
        }
        
//        dd($movies);
        return $movies;
    }
	
    private function checkExistingMovieDB($id){
        if (Movie::where('movieID', $id)->first()) {
            return true;
        }
        return false;
    }
	
    private function insertMovieDB($movies) {
        
        foreach ($movies as $_movie) {
            
            $movieId = $_movie->getId();
            $releaseData = $_movie->getReleaseDate();
            // skip insert if value already exists in db
            if ($this->checkExistingMovieDB($movieId))
                continue;
            
            $genres_ = array();
            $movie = new Movie();
            $movie->originalTitle = $_movie->getOriginalTitle();
            $movie->releaseData = $releaseData;
            $movie->movieID = $movieId;
            
            $genres = $_movie->getGenres();
            foreach($genres as $genreId){
                $genre = $this->getGenreNameTMDB($genreId->getId());
                $genres_[] = $genre;
            }
//            dd(implode(",", $genres_));
            $movie->genres = implode(",", $genres_);
            
            // save movie in db
            $movie->save();
            if(!$movie->id){
                return false;
            }
        }
        return true;
    }
    
    public function fetchMoviesTMDB() {
        //get no of pages from results
        $movies = $this->discover->discoverMovies($this->query);
        $resultPages = $movies->getTotalPages();
        // get all movies from all pages
        $moviesSets = $this->getMoviesTMDB($resultPages);
        
        foreach ($moviesSets as $moviesSet) {
            $response = $this->insertMovieDB($moviesSet);
            if (!$response){
                return false;
            }
        }
        
        if (!$response) {
            dd("Something went wrong!");
        }
        
        $movies = Movie::where("releaseData", '>=', $this->currentTime)->orderBy("releaseData", "asc")->paginate(20); 
        $returnHTML = view('mresult', ['movies'=>$movies])->render();
        
        return json_encode($returnHTML);
    }
    
    public function getMovieDetailsTMDB(Request $request) {
        $requestData = $request->all();
        $movieId = $requestData['id'];
        $movie = $this->movie->load($movieId);
        
        $image = $movie->getPosterImage();
//        $this->helper->getHtml($image, 'w154', 260, 420);
        
        $details = array();
        $details['title']           = $movie->getTitle();
        $details['overview']        = $movie->getOverview();
        $details['popularity']      = $movie->getPopularity();
        $details['voteAverage']     = $movie->getVoteAverage();
        $details['voteCount']       = $movie->getVoteCount();
        $details['status']          = $movie->getStatus();
        $details['poster']          = $this->helper->getHtml($image, 'w154', 260, 420);
        $details['language']        = $movie->getOriginalLanguage();
        $details['genres']          = $this->getGenresTMDB($movie->getId());
        
        $movies = Movie::where("releaseData", '>=', $this->currentTime)->orderBy("releaseData", "asc")->paginate(20); 
        return json_encode($details);
    } 
    
    public function index(Request $request)
    {
        $movies = Movie::where("releaseData", '>=', $this->currentTime)->orderBy("releaseData", "asc")->paginate(20); 
        if ($request->ajax()) {
            return view('mresult', compact('movies'));
        }       
        return view('home',compact('movies'));
    }

}