<?php
/**
 * Code generated using LaraAdmin
 * Help: http://laraadmin.com
 * LaraAdmin is open-sourced software licensed under the MIT license.
 * Developed by: zhovtyj IT Solutions
 * Developer Website: http://zhovtyjitsolutions.com
 */

namespace zhovtyj\Laraadmin\Commands;

use Illuminate\Console\Command;

use zhovtyj\Laraadmin\CodeGenerator;

/**
 * Class Migration
 * @package zhovtyj\Laraadmin\Commands
 *
 * Command to generation new sample migration file or complete migration file from DB Context
 * if '--generate' parameter is used after command, it generate migration from database.
 */
class Migration extends Command
{
    // The command signature.
    protected $signature = 'la:migration {table} {--generate}';
    
    // The command description.
    protected $description = 'Generate Migrations for LaraAdmin';
    
    /**
     * Generate a Migration file either sample or from DB Context
     *
     * @return mixed
     */
    public function handle()
    {
        $table = $this->argument('table');
        $generateFromTable = $this->option('generate');
        if($generateFromTable) {
            $generateFromTable = true;
        }
        CodeGenerator::generateMigration($table, $generateFromTable, $this);
    }
}
