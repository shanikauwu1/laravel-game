<?php
/**
 * User: user
 * Date: 1/6/18
 * Time: 10:58 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\HomeRepositoryInterface as HomeRepository;
use Validator;
use \Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    private $gamerepo;
    public function __construct(HomeRepository $gamerepo)
    {
        $this->gamerepo=$gamerepo;
    }

    /**
     * Show the application index.
     *
     * @return Response
     */
    public function index()
    {
        return view('index');
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $input=['game_type' => 'required'];
        $input_msgs=['game_type.required' => 'Please select game type.'];

        $validator = Validator::make($data, $input,$input_msgs);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        //dd($data);
        $game=$this->gamerepo->saveGameData($data);

        if($game){
            return Redirect::to('run/'.$game);
        }
        else{
            return Redirect::to('/');
        }
        //return view('index');
    }

    public function run($id)
    {
        $game=$this->gamerepo->getGameData($id);
        if($game && $game->count()>0){
            $game_data=[];
            //dd($game_data);
            foreach($game as $gam){
                $game_data[]=json_decode($gam->grid);
            }
            //dd(json_encode($game_data));
            return view('game')->with(compact('game_data'));;
        }
        else{
            return Redirect::to('/');
        }
        //return view('index');
    }
}
