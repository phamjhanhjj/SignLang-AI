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
        if ($data->isEmpty()) {
            return '<p>Không có dữ liệu.</p>';
        }
        $columns = array_keys((array)$data[0]);
        $html = '<table border="1" cellpadding="5"><tr>';
        foreach ($columns as $col) {
            $html .= "<th>$col</th>";
        }
        $html .= '<th>Actions</th></tr>';

        foreach ($data as $row) {
            $rowArr = (array)$row;
            $id = $rowArr[$columns[0]];
            $html .= '<tr>';
            foreach ($columns as $col) {
                $html .= "<td>{$rowArr[$col]}</td>";
            }

            // Xử lý đặc biệt cho bảng student_topic_record có composite key
            if ($tableName === 'student_topic_record') {
                $studentId = $rowArr['student_id'];
                $topicId = $rowArr['topic_id'];
                $html .= "<td>
                    <button onclick=\"editData('{$tableName}', '{$studentId}', '{$topicId}')\">Sửa</button>
                    <button onclick=\"deleteData('{$tableName}', '{$studentId}', '{$topicId}')\">Xóa</button>
                </td>";
            } else {
                $html .= "<td>
                    <button onclick=\"editData('{$tableName}', '{$id}')\">Sửa</button>
                    <button onclick=\"deleteData('{$tableName}', '{$id}')\">Xóa</button>
                </td>";
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }
}
