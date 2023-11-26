<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class ActualizarRegistros extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'actualizar:registros';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza los registros de la tabla de alumnos';

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
         // Inicializar el contador en 0 y la maestría actual en una cadena vacía
         DB::statement("SET @contador := 0");
         DB::statement("SET @maestria_actual := ''");
 
         // Actualizar registros para cada maestría
         $maestrias = DB::table('alumnos')->select('maestria_id')->distinct()->get();
 
         foreach ($maestrias as $maestria) {
             $maestriaId = $maestria->maestria_id;
 
             DB::statement("
                 UPDATE alumnos
                 SET registro = (
                     CASE
                         WHEN maestria_id = '$maestriaId' AND maestria_id != @maestria_actual THEN
                             (@contador := 1) AND (@maestria_actual := maestria_id)
                         WHEN maestria_id = '$maestriaId' THEN
                             (@contador := @contador + 1)
                     END
                 )
                 WHERE maestria_id = '$maestriaId'
                 ORDER BY id
             ");
         }
 
         $this->info('Registros actualizados con éxito.');
     }
}
