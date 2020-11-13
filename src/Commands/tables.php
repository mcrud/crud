<?php

namespace mcrud\crud\Commands ;

use Illuminate\Console\Command;
use Carbon\Carbon;

class tables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create migrateion $$ models $$ controllers';

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
        $time = Carbon::now() ;
        $nnn =$time->format('M_d_Y_his_');
      //  dd($nnn);
        $sdolar = '$' ;
        $tab = 'table' ;
        $mixed = $sdolar.$tab ;
        $name = $this->ask('what is your table ?');

        $number_row = $this->ask('number of row');
        for ($i=0; $i <$number_row ; $i++) {
            $var = explode(' ',$this->ask('what is type row and name?'));
        $type_row[$var[1]] =$var[0];

            //$type_row[]= $i ;

        }
      //  dd($type_row);
       // $tostring = implode($type_row);


       // $path = "../../../database/migrations" ;


        $myFile = "database/migrations/".$nnn.$name.".php"; // or .php
        $fh = fopen($myFile, 'w'); // or die("error");

        $stringData = '
         <?php
         use Illuminate\Database\Migrations\Migration;
         use Illuminate\Database\Schema\Blueprint;
         use Illuminate\Support\Facades\Schema;

         class '.$name.' extends Migration
 {
     /**
      * Run the migrations.
      *
      * @return void
      */
     public function up()
     {
         Schema::create("'.$name.'", function (Blueprint $table) {
            $table->id();
';
$test = '';
            foreach ($type_row as $key => $value) {
                $test = $test . '           $table->'.$value.'("'.$key.'");'."\n";
            }
                $stringData2 = '$table->timestamps();
         });
     }

     /**
      * Reverse the migrations.
      *
      * @return void
      */
     public function down()
     {
         Schema::dropIfExists("'.$name.'");
     }
 }
         ?>

        ';

        $stringData = $stringData.$test.$stringData2;
        fwrite($fh, $stringData);
        fclose($fh);

        // end create table

        $dir = 'app/Models';
      if (!file_exists($dir)) {
             mkdir($dir);
      }
        $new_name = ucfirst($name) ;
      $myFile = "app/Models/".$new_name.".php"; // or .php
      $fh = fopen($myFile, 'w'); // or die("error");
      $stringData = '<?php
      namespace App\Models;
      use Illuminate\Database\Eloquent\Model;
      class '.$new_name.' extends Model
      {

        protected $table = "'.$name.'";
        public $timestamps = true;
        protected $guarded = [];

      }
     ?>
      ';
      fwrite($fh, $stringData);
     fclose($fh);

     // end model

     // create controller
     $id = '$'.$name;
        $required = 'required';
        $controller_name  = ucfirst($name).'Controller' ;
        $model =  "'\'".ucfirst($name);
        $model_name = str_replace("'",'',$model);
     $myFile = "app/Http/Controllers/".$controller_name.".php"; // or .php
     $fh = fopen($myFile, 'w'); // or die("error");
     $stringData = '<?php
     namespace App\Http\Controllers;

     use Illuminate\Http\Request;
     use App\Models'.$model_name.';
    class '.$controller_name.' extends Controller
      {
        public function index(Request $request)
        {
            $getData = '.$new_name.'::get();
            return view("",compact("getData")); // return view include view for example view(clients.index)

        }

        public function create()
        {
            return view("");  //return view creat example view(clients.create)

        }

        public function store(Request $request)
        {
            //
            $request->validate([
                "'.$key.'" => "'.$required.'"  // put another row in validate
            ]);


            '.$new_name.'::create($request->all());


            return redirect()->route(""); //return redirect view index example view(clients.index)
        }

        public function show('.$new_name.' '.$id.')
    {

    }


    public function edit('.$new_name.' '.$id.')
    {
        //
        return view("",compact("id"));  //return view creat example view(clients.edit)
    }

    public function update(Request $request,'.$new_name.' '.$id.')
    {
        //
        $request->validate([
            "'.$key.'" => "'.$required.'"  // put another row in validate
        ]);


        '.$id.'->update($request->all());


        return redirect()->route(""); //return redirect view index example view(clients.index)
    }

    public function destroy('.$new_name.' '.$id.')
    {
        //

        '.$id.'->delete();
        return redirect()->route(""); //return redirect view index example view(clients.index)

    }


    }


     ?>';
     fwrite($fh, $stringData);
    fclose($fh);

    }



}
