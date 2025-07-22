<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        // Sắp xếp dữ liệu theo thứ tự natural cho các ID
        $data = $this->getSortedTableData($tableName);

        if ($data->isEmpty()) {
            return '<div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>Không có dữ liệu</h3>
                        <p>Bảng này chưa có dữ liệu nào. Hãy thêm dữ liệu mới.</p>
                    </div>';
        }

        $columns = array_keys((array)$data[0]);
        $html = '<table border="1" cellpadding="5"><tr>';
        foreach ($columns as $col) {
            $html .= "<th>$col</th>";
        }
        $html .= '<th>Thao tác</th></tr>';

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
                    <div class='action-buttons'>
                        <button class='btn-edit' onclick=\"editData('{$tableName}', '{$studentId}', '{$topicId}')\" title='Chỉnh sửa thông tin'>
                            <i class='fas fa-edit'></i>
                            Sửa
                        </button>
                        <button class='btn-delete' onclick=\"deleteData('{$tableName}', '{$studentId}', '{$topicId}')\" title='Xóa dữ liệu'>
                            <i class='fas fa-trash'></i>
                            Xóa
                        </button>
                    </div>
                </td>";
            } else {
                $html .= "<td>
                    <div class='action-buttons'>
                        <button class='btn-edit' onclick=\"editData('{$tableName}', '{$id}')\" title='Chỉnh sửa thông tin'>
                            <i class='fas fa-edit'></i>
                            Sửa
                        </button>
                        <button class='btn-delete' onclick=\"deleteData('{$tableName}', '{$id}')\" title='Xóa dữ liệu'>
                            <i class='fas fa-trash'></i>
                            Xóa
                        </button>
                    </div>
                </td>";
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }

    // Hàm helper để sắp xếp dữ liệu theo thứ tự natural
    private function getSortedTableData($tableName) {
        // Lấy tất cả dữ liệu từ bảng
        $data = DB::table($tableName)->get();

        if ($data->isEmpty()) {
            return $data;
        }

        // Lấy tên cột đầu tiên (thường là primary key)
        $columns = array_keys((array)$data[0]);
        $primaryColumn = $columns[0];

        // Chuyển đổi collection thành array để sắp xếp
        $dataArray = $data->toArray();

        // Sắp xếp theo thứ tự natural number
        usort($dataArray, function($a, $b) use ($primaryColumn) {
            $aValue = (array)$a;
            $bValue = (array)$b;

            $aId = $aValue[$primaryColumn];
            $bId = $bValue[$primaryColumn];

            // Kiểm tra nếu ID có dạng prefix_number (ví dụ: word_1, student_2)
            if (preg_match('/^(.+)_(\d+)$/', $aId, $matchesA) &&
                preg_match('/^(.+)_(\d+)$/', $bId, $matchesB)) {

                // Nếu cùng prefix, so sánh theo số
                if ($matchesA[1] === $matchesB[1]) {
                    return (int)$matchesA[2] - (int)$matchesB[2];
                }
                // Nếu khác prefix, so sánh theo string
                return strcmp($matchesA[1], $matchesB[1]);
            }

            // Nếu là số thuần túy
            if (is_numeric($aId) && is_numeric($bId)) {
                return (int)$aId - (int)$bId;
            }

            // Mặc định so sánh theo string
            return strcmp($aId, $bId);
        });

        // Chuyển đổi lại thành collection
        return collect($dataArray);
    }
}
