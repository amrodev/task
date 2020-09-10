<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Calculation;
use File;
class calculate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:calculate {argument1} {argument2}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates the average, area, & squared value of area';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $argument1 = $this->argument('argument1');
        $argument2 = $this->argument('argument2');

        $array = array($argument1,$argument2);
        $average = array_sum($array) / count($array);
        $area = $argument1*$argument2;
        $pow = pow($area,2);

        $latest_calcs = Calculation::orderBy('created_at', 'DESC')->take(5)->get();
        $calculation = new Calculation();
        $calculation->argument1 = $argument1;
        $calculation->argument2 = $argument2;
        $calculation->average = $average;
        $calculation->area = $area;
        $calculation->squared_area = $pow;
        $calculation->save();
        $this->info("=============== Current ===================");
        $this->info("Argument 1 : $argument1 || Argument 2 :  $argument2  || average : $average || area : $area || squared value of area : $pow");
        // $this->info(" ");
        // $this->info("squared value of area :  ");
       
        $this->info("============= latest 5 Records ============"); 
        foreach ($latest_calcs as  $index =>$calc) {
            $serial = $index+1;
            $this->info(" #$serial Argument 1 : $calc->argument1 || Argument 2 :  $calc->argument2  || average : $calc->average || area : $calc->area || squared value of area : $calc->squared_area");
        }
        $this->info("============= Thank You ===================");
        $this->generateHtml($latest_calcs);
    }

    private function generateHtml($latest_calcs)
    {
        $file = time() .rand(). '_calcs.html';
        $destinationPath = public_path()."/upload/";
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
        $html = '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
                   <title>Results</title></head><body><div class="container-fluid"><table class="table table-striped"><thead><tr><th>#</th><th>Argument 1</th> <th>Argument 2</th><th>Average</th><th>Area</th><th>Squared value of Area</th></tr>
                   </thead><tbody>';
        foreach ($latest_calcs as $index => $calc) {
            $serial = $index+1;
            $html .= "<tr></tr>";
            $html .= "<td>$serial</td>";
            $html .= "<td>$calc->argument1 </td>";
            $html .= "<td>$calc->argument2</td>";
            $html .= "<td>$calc->average</td>";
            $html .= "<td>$calc->area</td>";
            $html .= "<td>$calc->squared_area</td>";
            $html .= "</tr>";
        }           
        $html .= '</tbody></table></div><script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script></body></html>';
        File::put($destinationPath.$file,$html);
        $this->info("file created at $destinationPath".$file);
    }
}
