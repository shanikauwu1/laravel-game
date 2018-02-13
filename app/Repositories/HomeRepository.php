<?php
/**
 * User: user
 * Date: 1/6/18
 * Time: 10:58 AM
 */

namespace App\Repositories;

use App\Models\GameData;
use App\Models\GameDataGrid;

class HomeRepository implements HomeRepositoryInterface
{
    private $run=0;
    public function saveGameData($data)
    {
        $insert_data['game_name'] = "New game ".time();
        $insert_data['name'] = $data['game_type'];
        $game_data = GameData::create($insert_data);

        if($game_data && isset($data['game_type'])){
            if($data['game_type']==1){
                return $this->saveGameDataGrid(1, $game_data->id);
            }
            else{
                return $this->saveGameDataGrid(2, $game_data->id);
            }
        }
        return 0;
    }

    public function saveGameDataGrid($type,$game_id)
    {
        $random_percentage=45;
        $game_data_grid=new GameDataGrid();
        $data_grid=[];
        if($type==1){
            //for($x = 1 ; $x <= 100 ; $x++){
                for ( $x = 0 ; $x < 38 ; $x++) {
                    for ( $y = 0 ; $y < 38 ; $y++) {
                        $random_val = mt_rand(1,100);
                        $data_grid[$x][$y]= ($random_val < $random_percentage)?1:0;
                    }
                }

                $game_data_grid->game_id=$game_id;
                $game_data_grid->grid=json_encode($data_grid);
                $game_data_grid->save();
           // }

        }
        else{

            for ( $l = 0 ; $l < 38 ; $l++) {
                for ( $m = 0 ; $m < 38 ; $m++) {
                    $data_grid[$l][$m]=0;
                }
            }

            $x = 19;
            $y = 6;
            $data_grid[$y][$x-18]=1;
            $data_grid[$y][$x-17]=1;
            $data_grid[$y-1][$x-17]=1;
            $data_grid[$y-4][$x-5]=1;
            $data_grid[$y-4][$x-6]=1;
            $data_grid[$y-3][$x-7]=1;
            $data_grid[$y-2][$x-8]=1;
            $data_grid[$y-1][$x-8]=1;
            $data_grid[$y][$x-8]=1;
            $data_grid[$y+1][$x-7]=1;
            $data_grid[$y+2][$x-6]=1;
            $data_grid[$y+2][$x-5]=1;
            $data_grid[$y-1][$x+5]=1;
            $data_grid[$y-1][$x+6]=1;
            $data_grid[$y-2][$x+6]=1;
            $data_grid[$y+3][$x+5]=1;
            $data_grid[$y+3][$x+6]=1;
            $data_grid[$y+4][$x+6]=1;
            $data_grid[$y][$x+8]=1;
            $data_grid[$y][$x+9]=1;
            $data_grid[$y+1][$x+8]=1;
            $data_grid[$y+1][$x+9]=1;
            $data_grid[$y+1][$x+10]=1;
            $data_grid[$y+2][$x+8]=1;
            $data_grid[$y+2][$x+9]=1;
            $data_grid[$y+2][$x+16]=1;
            $data_grid[$y+2][$x+17]=1;
            $data_grid[$y+1][$x+17]=1;

            $game_data_grid->game_id=$game_id;
            $game_data_grid->grid=json_encode($data_grid);
            $game_data_grid->save();
        }

        if(count($data_grid)>0){
            $this->run=1;
            $this->nextIterate($data_grid,$game_id);
        }

        return $game_id;
    }

    private function nextIterate($current_gen,$game_id){
        //for($k = 1 ; $k < 100 ; $k++){

            $next_gen = []; // New array to hold the next gen cells
            $length_y = 38;

            // each row
            for ($y = 0; $y < $length_y; $y++) {
                $length_x = 38;
                $next_gen[$y] = []; // Init new row
                // each column in rows
                for ($x = 0; $x < $length_x; $x++) {
                    // state = ($current_gen[$y][$x] == 1) ? '1' : '0';
                    $cell = $current_gen[$y][$x];
                    // Calculate above/below/left/right row/column values
                    $row_above = ($y-1 >= 0) ? $y-1 : $length_y-1; // If current cell is on first row, cell above is the last row
                    $row_below = ($y+1 <= $length_y-1) ? $y+1 : 0; // If current cell is in last row, then cell below is the first row
                    $column_left = ($x-1 >= 0) ? $x-1 : $length_x - 1; // If current cell is on first row, then left cell is the last row
                    $column_right = ($x+1 <= $length_x-1) ? $x+1 : 0; // If current cell is on last row, then right cell is in the first row

                    $neighbours = [
                          "top_left"=> $current_gen[$row_above][$column_left],
                          "top_center"=> $current_gen[$row_above][$x],
                          "top_right"=> $current_gen[$row_above][$column_right],
                          "left"=> $current_gen[$y][$column_left],
                          "right"=> $current_gen[$y][$column_right],
                          "bottom_left"=> $current_gen[$row_below][$column_left],
                          "bottom_center"=> $current_gen[$row_below][$x],
                          "bottom_right"=> $current_gen[$row_below][$column_right]
                        ];

                $alive_count = 0;
                $dead_count = 0;

                foreach($neighbours as $neighbour){
                    if($neighbour==0){
                        $dead_count++;
                    }else{
                        $alive_count++;
                    }
                }

                // Set new state to current state, but it may change below
                    $new_state = $cell;
                if ($cell == 1) {
                    if ($alive_count < 2 || $alive_count > 3) {
                        // new state: 0, overpopulation/ underpopulation
                        $new_state = 0;
                    } else if ($alive_count === 2 || $alive_count === 3) {
                        // lives on to next generation
                        $new_state = 1;
                    }
                } else {
                    if ($alive_count === 3) {
                        // new state: 1, reproduction
                        $new_state = 1;
                    }
                }


                $next_gen[$y][$x] = $new_state;
              }
            }

            $game_data_grid=new GameDataGrid();
            $game_data_grid->game_id=$game_id;
            $game_data_grid->grid=json_encode($next_gen);
            $game_data_grid->save();

            $this->run = $this->run+1;
            //dd($this->run);
            if($this->run < 100){
                $this->nextIterate($next_gen,$game_id);
            }
            //return $next_gen;
        //}
    }

    public function getGameData($id){
        return GameDataGrid::select('grid')->where("game_id",$id)->orderBy('created_at')->get();
    }

}