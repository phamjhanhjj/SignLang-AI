<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Controllers\DB;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index(){
        return view('dashboard');
    }

    //Lấy danh sách tất cả các bảng trong database
    public function getTables(){
        $tables = DB::select('SHOW TABLES');
        $tableKey = 'Tables_in_' . DB::getDatabaseName();
        $tableNames = array_map(function($table) use ($tableKey) {
            return $table->$tableKey;
        }, $tables);
        return response()->json($tableNames);
    }

    //Lấy dữ liệu của một bảng cụ thể
    public function getTableData($tableName) {
        $data = DB::table($tableName)->get();
        $html = '<table border="1" cellpadding="5"><tr>';
        foreach (array_keys((array)$data[0]) as $col) {
            $html .= "<th>$col</th>";
        }
        $html .= '</tr>';
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ((array)$row as $value) {
                $html .= "<td>$value</td>";
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }
}
