<!DOCTYPE html>
<html>
    <head>
             <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Dashboard</title>
         <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f5f7fa;
                color: #333;
            }

            .header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 20px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }

            .header h1 {
                font-size: 2.5em;
                margin-bottom: 10px;
            }

            .header p {
                opacity: 0.9;
                font-size: 1.1em;
            }

            .dashboard-container {
                display: flex;
                min-height: calc(100vh - 140px);
                gap: 20px;
                padding: 20px;
            }

            .sidebar {
                width: 300px;
                background: white;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.08);
                padding: 20px;
                height: fit-content;
                position: sticky;
                top: 20px;
            }

            .sidebar h3 {
                color: #4a5568;
                margin-bottom: 20px;
                font-size: 1.3em;
                padding-bottom: 10px;
                border-bottom: 2px solid #e2e8f0;
            }

            .table-list {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .table-item {
                padding: 12px 16px;
                background: #f8fafc;
                border: 2px solid transparent;
                border-radius: 8px;
                cursor: pointer;
                transition: all 0.3s ease;
                font-weight: 500;
                color: #4a5568;
                position: relative;
                overflow: hidden;
            }

            .table-item::before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                height: 100%;
                width: 4px;
                background: #667eea;
                transform: scaleY(0);
                transition: transform 0.3s ease;
            }

            .table-item:hover {
                background: linear-gradient(135deg, #667eea15, #764ba215);
                border-color: #667eea;
                color: #2d3748;
                transform: translateX(5px);
            }

            .table-item:hover::before {
                transform: scaleY(1);
            }

            .table-item.active {
                background: linear-gradient(135deg, #667eea, #764ba2);
                color: white;
                transform: translateX(5px);
            }

            .table-item.active::before {
                transform: scaleY(1);
                background: rgba(255,255,255,0.3);
            }

            .main-content {
                flex: 1;
                background: white;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.08);
                padding: 30px;
                min-height: 600px;
            }

            .content-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 2px solid #e2e8f0;
            }

            .content-title {
                font-size: 1.8em;
                color: #2d3748;
                font-weight: 600;
            }

            #crud-buttons {
                display: flex;
                gap: 12px;
                margin-bottom: 20px;
            }

            #crud-buttons button {
                background: linear-gradient(135deg, #48bb78, #38a169);
                color: white;
                border: none;
                padding: 12px 24px;
                border-radius: 8px;
                cursor: pointer;
                font-weight: 600;
                transition: all 0.3s ease;
                box-shadow: 0 2px 10px rgba(72, 187, 120, 0.3);
            }

            #crud-buttons button:hover {
                background: linear-gradient(135deg, #38a169, #2f855a);
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(72, 187, 120, 0.4);
            }

            .empty-state {
                text-align: center;
                padding: 80px 20px;
                color: #718096;
            }

            .empty-state i {
                font-size: 4em;
                margin-bottom: 20px;
                color: #cbd5e0;
            }

            .empty-state h3 {
                font-size: 1.5em;
                margin-bottom: 10px;
                color: #4a5568;
            }

            .empty-state p {
                font-size: 1.1em;
                line-height: 1.6;
            }

            .data-table {
                overflow-x: auto;
            }

            .data-table table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 8px;
                overflow: hidden;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            }

            .data-table th {
                background: linear-gradient(135deg, #667eea, #764ba2);
                color: white;
                padding: 15px;
                text-align: left;
                font-weight: 600;
                font-size: 0.95em;
            }

            .data-table td {
                padding: 12px 15px;
                border-bottom: 1px solid #e2e8f0;
                color: #4a5568;
            }

            .data-table tr:hover {
                background: #f8fafc;
            }

            .data-table tr:last-child td {
                border-bottom: none;
            }

            /* CSS cho nút sửa/xóa đẹp hơn */
            .action-buttons {
                display: flex;
                gap: 8px;
                align-items: center;
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn-edit, .btn-delete {
                padding: 8px 12px;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                font-size: 0.85em;
                font-weight: 500;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                min-width: 70px;
                justify-content: center;
                text-decoration: none;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .btn-edit {
                background: linear-gradient(135deg, #4299e1, #3182ce);
                color: white;
            }

            .btn-edit:hover {
                background: linear-gradient(135deg, #3182ce, #2c5282);
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(66, 153, 225, 0.3);
            }

            .btn-delete {
                background: linear-gradient(135deg, #f56565, #e53e3e);
                color: white;
            }

            .btn-delete:hover {
                background: linear-gradient(135deg, #e53e3e, #c53030);
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(245, 101, 101, 0.3);
            }

            .btn-edit i, .btn-delete i {
                font-size: 0.8em;
            }

            .btn-edit:active, .btn-delete:active {
                transform: scale(0.95);
            }

            /* Tooltip hiệu ứng */
            .btn-edit[title]:hover::after, .btn-delete[title]:hover::after {
                content: attr(title);
                position: absolute;
                bottom: 100%;
                left: 50%;
                transform: translateX(-50%);
                background: rgba(0, 0, 0, 0.8);
                color: white;
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 0.75em;
                white-space: nowrap;
                z-index: 1000;
                margin-bottom: 4px;
                pointer-events: none;
            }

            /* Responsive cho nút */
            @media (max-width: 768px) {
                .dashboard-container {
                    flex-direction: column;
                }

                .sidebar {
                    width: 100%;
                    position: static;
                }

                .table-list {
                    flex-direction: row;
                    flex-wrap: wrap;
                }

                .table-item {
                    flex: 1;
                    min-width: 150px;
                }

                .action-buttons {
                    flex-direction: column;
                    gap: 4px;
                }

                .btn-edit, .btn-delete {
                    padding: 6px 10px;
                    font-size: 0.8em;
                    min-width: 60px;
                }
            }

            /* Hiệu ứng loading khi click */
            .btn-edit:focus, .btn-delete:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.3);
            }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>

    <body>
        <div class="header">
            <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
            <p>Quản lý cơ sở dữ liệu hệ thống học ngôn ngữ ký hiệu</p>
        </div>

        <div class="dashboard-container">
            <div class="sidebar">
                <h3><i class="fas fa-database"></i> Danh sách bảng</h3>
                <div id="all-tables" class="table-list"></div>
            </div>

            <div class="main-content">
                <div class="content-header">
                    <div class="content-title" id="current-table-title">
                        <i class="fas fa-table"></i> Chọn bảng để xem dữ liệu
                    </div>
                </div>
                <div id="data-table" class="data-table">
                    <div class="empty-state">
                        <i class="fas fa-mouse-pointer"></i>
                        <h3>Chưa chọn bảng nào</h3>
                        <p>Vui lòng chọn một bảng từ danh sách bên trái để xem dữ liệu</p>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let currentActiveTable = null;

            // Lấy danh sách tất cả các bảng trong database và hiển thị thành các item
            function loadAllTables() {
                fetch('/dashboard/tables')
                    .then(res => res.json())
                    .then(tables => {
                        // Sắp xếp bảng theo alphabet
                        tables.sort((a, b) => a.localeCompare(b));

                        let html = '';
                        tables.forEach(table => {
                            // Tạo tên hiển thị đẹp hơn
                            const displayName = formatTableName(table);
                            html += `<div class="table-item" onclick="selectTable('${table}')" data-table="${table}">
                                        <i class="fas fa-table"></i> ${displayName}
                                    </div>`;
                        });
                        document.getElementById('all-tables').innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Lỗi khi tải danh sách bảng:', error);
                        document.getElementById('all-tables').innerHTML =
                            '<div style="color: #e53e3e; padding: 20px; text-align: center;">Không thể tải danh sách bảng</div>';
                    });
            }

            // Format tên bảng để hiển thị đẹp hơn
            function formatTableName(tableName) {
                const nameMap = {
                    'student': 'Sinh viên',
                    'course': 'Khóa học',
                    'topic': 'Chủ đề',
                    'word': 'Từ vựng',
                    'learn_videos': 'Video học tập',
                    'practise_video': 'Video thực hành',
                    'word_practise_video': 'Video thực hành từ',
                    'enrolment': 'Đăng ký khóa học',
                    'student_practise_video_record': 'Bản ghi thực hành video',
                    'student_word_record': 'Bản ghi học từ',
                    'student_topic_record': 'Bản ghi học chủ đề',
                    'student_progress': 'Tiến độ học tập'
                };
                return nameMap[tableName] || tableName.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            }

            // Chọn bảng và hiển thị dữ liệu
            function selectTable(table) {
                // Cập nhật trạng thái active
                if (currentActiveTable) {
                    document.querySelector(`[data-table="${currentActiveTable}"]`).classList.remove('active');
                }
                document.querySelector(`[data-table="${table}"]`).classList.add('active');
                currentActiveTable = table;

                // Cập nhật tiêu đề
                document.getElementById('current-table-title').innerHTML =
                    `<i class="fas fa-table"></i> ${formatTableName(table)}`;

                showData(table);
            }

            // Hiển thị dữ liệu cho từng bảng khi người dùng chọn
            function showData(table) {
                // Hiển thị nút thêm dữ liệu bên trên bảng dữ liệu
                let crudHtml = `
                    <div id="crud-buttons">
                        <button onclick="addData('${table}')">
                            <i class="fas fa-plus"></i> Thêm dữ liệu
                        </button>
                    </div>
                `;
                document.getElementById('data-table').innerHTML = crudHtml +
                    '<div style="text-align: center; padding: 40px; color: #718096;"><i class="fas fa-spinner fa-spin"></i> Đang tải dữ liệu...</div>';

                // Hiển thị dữ liệu của bảng
                fetch(`/dashboard/data/${table}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('data-table').innerHTML = crudHtml + html;
                    })
                    .catch(error => {
                        console.error('Lỗi khi tải dữ liệu:', error);
                        document.getElementById('data-table').innerHTML = crudHtml +
                            '<div style="color: #e53e3e; text-align: center; padding: 40px;">Không thể tải dữ liệu bảng</div>';
                    });
            }

            // Hàm thêm dữ liệu vào bảng
            function addData(table) {
                switch(table) {
                    case 'student':
                        showCreateStudentForm();
                        break;
                    case 'course':
                        showCreateCourseForm();
                        break;
                    case 'topic':
                        showCreateTopicForm();
                        break;
                    case 'learn_videos':
                        showCreateLearnVideosForm();
                        break;
                    case 'practise_video':
                        showCreatePractiseVideoForm();
                        break;
                    case 'word_practise_video':
                        showCreateWordPractiseVideoForm();
                        break;
                    case 'enrolment':
                        showCreateEnrolmentForm();
                        break;
                    case 'student_practise_video_record':
                        showCreateStudentPractiseVideoRecordForm();
                        break;
                    case 'student_word_record':
                        showCreateStudentWordRecordForm();
                        break;
                    case 'student_topic_record':
                        showCreateStudentTopicRecordForm();
                        break;
                    case 'word':
                        showCreateWordForm();
                        break;
                    default:
                        alert('Chức năng thêm dữ liệu chưa được hỗ trợ cho bảng này.');
                        break;
                }
            }

            // Hiển thị form thêm Student
            function showCreateStudentForm() {
                // hideAllPopups();
                document.getElementById('add-student-form').style.display = 'block';
            }


            // Gửi form thêm Student
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('create-student-form');
                if (form) {
                    form.onsubmit = function(event) {
                        event.preventDefault(); // Ngăn chặn hành động mặc định của form
                        const formData = new FormData(form);
                        fetch('/student', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('student-form-message').innerText = 'Thêm Student thành công!';
                                form.reset();
                                setTimeout(() => {
                                document.getElementById('add-student-form').style.display = 'none';
                                document.getElementById('student-form-message').innerText = '';
                                showData('student');
                            }, 1000);// Hiển thị thông báo thành công
                            } else {
                                document.getElementById('student-form-message').innerText = 'Lỗi: ' + data.error; // Hiển thị lỗi nếu có
                            }
                        })
                        .catch(() => {
                            document.getElementById('student-form-message').innerText = 'Lỗi kết nối. Vui lòng thử lại sau.';
                        });
                    }
                }
            })
            window.onload = loadAllTables; // Tải danh sách bảng khi trang được tải

            // Hiển thị form thêm Course
            function showCreateCourseForm() {
                document.getElementById('add-course-form').style.display = 'block';
            }

            // Gửi form thêm Course
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('create-course-form');
                if (form) {
                    form.onsubmit = function(event) {
                        event.preventDefault(); // Ngăn chặn hành động mặc định của form
                        const formData = new FormData(form);
                        fetch('/course', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('course-form-message').innerText = 'Thêm Course thành công!';
                                form.reset();
                                setTimeout(() => {
                                    document.getElementById('add-course-form').style.display = 'none';
                                    document.getElementById('course-form-message').innerText = '';
                                    showData('course');
                                }, 1000); // Hiển thị thông báo thành công
                            } else {
                                document.getElementById('course-form-message').innerText = 'Lỗi: ' + data.error; // Hiển thị lỗi nếu có
                            }
                        })
                        .catch(() => {
                            document.getElementById('course-form-message').innerText = 'Lỗi kết nối. Vui lòng thử lại sau.';
                        });
                    }
                }
            })

            // Hiển thị form thêm Topic
            function showCreateTopicForm() {
                document.getElementById('add-topic-form').style.display = 'block';
                // Lấy danh sách khóa học để hiển thị trong dropdown
                fetch('/courses')
                .then(res => res.json())
                .then(data => {
                    const select = document.getElementById('topic-course-select');
                    select.innerHTML = '<option value="">-- Chọn khóa học --</option>';
                    if (data.success && data.data) {
                        data.data.forEach(course => {
                            select.innerHTML += `<option value="${course.course_id}">${course.nation} (${course.course_id})</option>`;
                        });
                    }
                });
            }
            // Gửi form thêm Topic
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('create-topic-form');
                if (form) {
                    form.onsubmit = function(event) {
                        event.preventDefault(); // Ngăn chặn hành động mặc định của form
                        const formData = new FormData(form);
                        fetch('/topic', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('topic-form-message').innerText = 'Thêm Topic thành công!';
                                form.reset();
                                setTimeout(() => {
                                    document.getElementById('add-topic-form').style.display = 'none';
                                    document.getElementById('topic-form-message').innerText = '';
                                    showData('topic');
                                }, 1000); // Hiển thị thông báo thành công
                            } else {
                                document.getElementById('topic-form-message').innerText = 'Lỗi: ' + data.error; // Hiển thị lỗi nếu có
                            }
                        })
                        .catch(() => {
                            document.getElementById('topic-form-message').innerText = 'Lỗi kết nối. Vui lòng thử lại sau.';
                        });
                    }
                }
            })

            // Hiển thị form thêm Learn Videos
            function showCreateLearnVideosForm() {
                document.getElementById('add-learn-videos-form').style.display = 'block';
                // Lấy danh sách từ để hiển thị trong dropdown
                fetch('/words')
                    .then(res => res.json())
                    .then(data => {
                        const select = document.getElementById('learn-videos-word-select');
                        select.innerHTML = '<option value="">-- Chọn từ --</option>';
                        if (data.success && data.data) {
                            data.data.forEach(word => {
                                select.innerHTML += `<option value="${word.word_id}">${word.word} (${word.word_id})</option>`;
                            });
                        }
                    });
            }

            // Gửi form thêm Learn Videos
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('create-learn-videos-form');
                if (form) {
                    form.onsubmit = function(event) {
                        event.preventDefault(); // Ngăn chặn hành động mặc định của form
                        const formData = new FormData(form);
                        fetch('/learn-video', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('learn-videos-form-message').innerText = 'Thêm Learn Video thành công!';
                                form.reset();
                                setTimeout(() => {
                                    document.getElementById('add-learn-videos-form').style.display = 'none';
                                    document.getElementById('learn-videos-form-message').innerText = '';
                                    showData('learn_videos');
                                }, 1000); // Hiển thị thông báo thành công
                            } else {
                                document.getElementById('learn-videos-form-message').innerText = 'Lỗi: ' + data.error; // Hiển thị lỗi nếu có
                            }
                        })
                        .catch(() => {
                            document.getElementById('learn-videos-form-message').innerText = 'Lỗi kết nối. Vui lòng thử lại sau.';
                        });
                    }
                }
            })

            // Hiển thị form thêm Practise Video
            function showCreatePractiseVideoForm() {
                document.getElementById('add-practise-video-form').style.display = 'block';
                // Lấy danh sách khóa học để hiển thị trong dropdown
                fetch('/courses')
                    .then(res => res.json())
                    .then(data => {
                        const select = document.getElementById('practise-video-course-select');
                        select.innerHTML = '<option value="">-- Chọn khóa học --</option>';
                        if (data.success && data.data) {
                            data.data.forEach(course => {
                                select.innerHTML += `<option value="${course.course_id}">${course.nation} (${course.course_id})</option>`;
                            });
                        }
                    });
            }

            // Gửi form thêm Practise Video
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('create-practise-video-form');
                if (form) {
                    form.onsubmit = function(event) {
                        event.preventDefault(); // Ngăn chặn hành động mặc định của form
                        const formData = new FormData(form);
                        fetch('/practise-video', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('practise-video-form-message').innerText = 'Thêm Practise Video thành công!';
                                form.reset();
                                setTimeout(() => {
                                    document.getElementById('add-practise-video-form').style.display = 'none';
                                    document.getElementById('practise-video-form-message').innerText = '';
                                    showData('practise_video');
                                }, 1000); // Hiển thị thông báo thành công
                            } else {
                                document.getElementById('practise-video-form-message').innerText = 'Lỗi: ' + data.error; // Hiển thị lỗi nếu có
                            }
                        })
                        .catch(() => {
                            document.getElementById('practise-video-form-message').innerText = 'Lỗi kết nối. Vui lòng thử lại sau.';
                        });
                    }
                }
            })


            // Hiển thị form thêm Word Practise Video
            function showCreateWordPractiseVideoForm() {
                document.getElementById('add-word-practise-video-form').style.display = 'block';
                // Lấy danh sách từ để hiển thị trong dropdown
                fetch('/words')
                    .then(res => res.json())
                    .then(data => {
                        const wordSelect = document.getElementById('word-practise-video-word-select');
                        wordSelect.innerHTML = '<option value="">-- Chọn từ --</option>';
                        if (data.success && data.data) {
                            data.data.forEach(word => {
                                wordSelect.innerHTML += `<option value="${word.word_id}">${word.word} (${word.word_id})</option>`;
                            });
                        }
                    });
                // Lấy danh sách video thực hành để hiển thị trong dropdown
                fetch('/practise-videos')
                    .then(res => res.json())
                    .then(data => {
                        const videoSelect = document.getElementById('word-practise-video-video-select');
                        videoSelect.innerHTML = '<option value="">-- Chọn video thực hành --</option>';
                        if (data.success && data.data) {
                            data.data.forEach(video => {
                                videoSelect.innerHTML += `<option value="${video.practise_video_id}">${video.video_link} (${video.practise_video_id})</option>`;
                            });
                        }
                    });
            }

            // Gửi form thêm Word Practise Video
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('create-word-practise-video-form');
                if (form) {
                    form.onsubmit = function(event) {
                        event.preventDefault(); // Ngăn chặn hành động mặc định của form
                        const formData = new FormData(form);
                        fetch('/word-practise-video', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('word-practise-video-form-message').innerText = 'Thêm Word Practise Video thành công!';
                                form.reset();
                                setTimeout(() => {
                                    document.getElementById('add-word-practise-video-form').style.display = 'none';
                                    document.getElementById('word-practise-video-form-message').innerText = '';
                                    showData('word_practise_video');
                                }, 1000); // Hiển thị thông báo thành công
                            } else {
                                document.getElementById('word-practise-video-form-message').innerText = 'Lỗi: ' + data.error; // Hiển thị lỗi nếu có
                            }
                        })
                        .catch(() => {
                            document.getElementById('word-practise-video-form-message').innerText = 'Lỗi kết nối. Vui lòng thử lại sau.';
                        });
                    }
                }
            })

            // Hiển thị form thêm Enrolment
            function showCreateEnrolmentForm() {
                document.getElementById('add-enrolment-form').style.display = 'block';
                // Lấy danh sách sinh viên để hiển thị trong dropdown
                fetch('/students')
                    .then(res => res.json())
                    .then(data => {
                        const studentSelect = document.getElementById('enrolment-student-select');
                        studentSelect.innerHTML = '<option value="">-- Chọn sinh viên --</option>';
                        if (data.success && data.data) {
                            data.data.forEach(student => {
                                studentSelect.innerHTML += `<option value="${student.student_id}">${student.username} (${student.student_id})</option>`;
                            });
                        }
                    });
                // Lấy danh sách khóa học để hiển thị trong dropdown
                fetch('/courses')
                    .then(res => res.json())
                    .then(data => {
                        const courseSelect = document.getElementById('enrolment-course-select');
                        courseSelect.innerHTML = '<option value="">-- Chọn khóa học --</option>';
                        if (data.success && data.data) {
                            data.data.forEach(course => {
                                courseSelect.innerHTML += `<option value="${course.course_id}">${course.nation} (${course.course_id})</option>`;
                            });
                        }
                    });
            }

            // Gửi form thêm Enrolment
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('create-enrolment-form');
                if (form) {
                    form.onsubmit = function(event) {
                        event.preventDefault(); // Ngăn chặn hành động mặc định của form
                        const formData = new FormData(form);
                        fetch('/enrolment', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('enrolment-form-message').innerText = 'Thêm Enrolment thành công!';
                                form.reset();
                                setTimeout(() => {
                                    document.getElementById('add-enrolment-form').style.display = 'none';
                                    document.getElementById('enrolment-form-message').innerText = '';
                                    showData('enrolment');
                                }, 1000); // Hiển thị thông báo thành công
                            } else {
                                document.getElementById('enrolment-form-message').innerText = 'Lỗi: ' + data.error; // Hiển thị lỗi nếu có
                            }
                        })
                        .catch(() => {
                            document.getElementById('enrolment-form-message').innerText = 'Lỗi kết nối. Vui lòng thử lại sau.';
                        });
                    }
                }
            })
            //Hiển thị form thêm Student Practise Video Record
            function showCreateStudentPractiseVideoRecordForm() {
                document.getElementById('add-student-practise-video-record-form').style.display = 'block';
                // Lấy danh sách sinh viên để hiển thị trong dropdown
                fetch('/students')
                    .then(res => res.json())
                    .then(data => {
                        const studentSelect = document.getElementById('student-practise-video-record-student-select');
                        studentSelect.innerHTML = '<option value="">-- Chọn sinh viên --</option>';
                        if (data.success && data.data) {
                            data.data.forEach(student => {
                                studentSelect.innerHTML += `<option value="${student.student_id}">${student.username} (${student.student_id})</option>`;
                            });
                        }
                    });
                // Lấy danh sách video thực hành để hiển thị trong dropdown
                fetch('/practise-videos')
                    .then(res => res.json())
                    .then(data => {
                        const videoSelect = document.getElementById('student-practise-video-record-video-select');
                        videoSelect.innerHTML = '<option value="">-- Chọn video thực hành --</option>';
                        if (data.success && data.data) {
                            data.data.forEach(video => {
                                videoSelect.innerHTML += `<option value="${video.practise_video_id}">${video.video_link} (${video.practise_video_id})</option>`;
                            });
                        }
                    });
            }

            // Gửi form thêm Student Practise Video Record
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('create-student-practise-video-record-form');
                if (form) {
                    form.onsubmit = function(event) {
                        event.preventDefault(); // Ngăn chặn hành động mặc định của form
                        const formData = new FormData(form);
                        fetch('/student-practise-video-record', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('student-practise-video-record-form-message').innerText = 'Thêm Student Practise Video Record thành công!';
                                form.reset();
                                setTimeout(() => {
                                    document.getElementById('add-student-practise-video-record-form').style.display = 'none';
                                    document.getElementById('student-practise-video-record-form-message').innerText = '';
                                    showData('student_practise_video_record');
                                }, 1000); // Hiển thị thông báo thành công
                            } else {
                                document.getElementById('student-practise-video-record-form-message').innerText = 'Lỗi: ' + data.error; // Hiển thị lỗi nếu có
                            }
                        })
                        .catch(() => {
                            document.getElementById('student-practise-video-record-form-message').innerText = 'Lỗi kết nối. Vui lòng thử lại sau.';
                        });
                    }
                }
            })

            // Hiển thị form thêm Student Word Record
            function showCreateStudentWordRecordForm() {
                document.getElementById('add-student-word-record-form').style.display = 'block';
                // Lấy danh sách sinh viên để hiển thị trong dropdown
                fetch('/students')
                    .then(res => res.json())
                    .then(data => {
                        const studentSelect = document.getElementById('student-word-record-student-select');
                        studentSelect.innerHTML = '<option value="">-- Chọn sinh viên --</option>';
                        if (data.success && data.data) {
                            data.data.forEach(student => {
                                studentSelect.innerHTML += `<option value="${student.student_id}">${student.username} (${student.student_id})</option>`;
                            });
                        }
                    });
                // Lấy danh sách từ để hiển thị trong dropdown
                fetch('/words')
                    .then(res => res.json())
                    .then(data => {
                        const wordSelect = document.getElementById('student-word-record-word-select');
                        wordSelect.innerHTML = '<option value="">-- Chọn từ --</option>';
                        if (data.success && data.data) {
                            data.data.forEach(word => {
                                wordSelect.innerHTML += `<option value="${word.word_id}">${word.word} (${word.word_id})</option>`;
                            });
                        }
                    });
            }

            // Gửi form thêm Student Word Record
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('create-student-word-record-form');
                if (form) {
                    form.onsubmit = function(event) {
                        event.preventDefault(); // Ngăn chặn hành động mặc định của form
                        const formData = new FormData(form);
                        fetch('/student-word-record', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('student-word-record-form-message').innerText = 'Thêm Student Word Record thành công!';
                                form.reset();
                                setTimeout(() => {
                                    document.getElementById('add-student-word-record-form').style.display = 'none';
                                    document.getElementById('student-word-record-form-message').innerText = '';
                                    showData('student_word_record');
                                }, 1000); // Hiển thị thông báo thành công
                            } else {
                                document.getElementById('student-word-record-form-message').innerText = 'Lỗi: ' + data.error; // Hiển thị lỗi nếu có
                            }
                        })
                        .catch(() => {
                            document.getElementById('student-word-record-form-message').innerText = 'Lỗi kết nối. Vui lòng thử lại sau.';
                        });
                    }
                }
            })
            // Hiển thị form thêm Student Topic Record
            function showCreateStudentTopicRecordForm() {
                document.getElementById('add-student-topic-record-form').style.display = 'block';
                // Lấy danh sách sinh viên để hiển thị trong dropdown
                fetch('/students')
                    .then(res => res.json())
                    .then(data => {
                        const studentSelect = document.getElementById('student-topic-record-student-select');
                        studentSelect.innerHTML = '<option value="">-- Chọn sinh viên --</option>';
                        if (data.success && data.data) {
                            data.data.forEach(student => {
                                studentSelect.innerHTML += `<option value="${student.student_id}">${student.username} (${student.student_id})</option>`;
                            });
                        }
                    });
                // Lấy danh sách chủ đề để hiển thị trong dropdown
                fetch('/topics')
                    .then(res => res.json())
                    .then(data => {
                        const topicSelect = document.getElementById('student-topic-record-topic-select');
                        topicSelect.innerHTML = '<option value="">-- Chọn chủ đề --</option>';
                        if (data.success && data.data) {
                            data.data.forEach(topic => {
                                topicSelect.innerHTML += `<option value="${topic.topic_id}">${topic.name} (${topic.topic_id})</option>`;
                            });
                        }
                    });
            }
            // Gửi form thêm Student Topic Record
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('create-student-topic-record-form');
                if (form) {
                    form.onsubmit = function(event) {
                        event.preventDefault(); // Ngăn chặn hành động mặc định của form
                        const formData = new FormData(form);
                        fetch('/student-topic-record', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('student-topic-record-form-message').innerText = 'Thêm Student Topic Record thành công!';
                                form.reset();
                                setTimeout(() => {
                                    document.getElementById('add-student-topic-record-form').style.display = 'none';
                                    document.getElementById('student-topic-record-form-message').innerText = '';
                                    showData('student_topic_record');
                                }, 1000); // Hiển thị thông báo thành công
                            } else {
                                document.getElementById('student-topic-record-form-message').innerText = 'Lỗi: ' + data.error; // Hiển thị lỗi nếu có
                            }
                        })
                        .catch(() => {
                            document.getElementById('student-topic-record-form-message').innerText = 'Lỗi kết nối. Vui lòng thử lại sau.';
                        });
                    }
                }
            })

            // Hiển thị form thêm Word
            function showCreateWordForm() {
                document.getElementById('add-word-form').style.display = 'block';
                // Lấy danh sách chủ đề để hiển thị trong dropdown
                fetch('/topics')
                    .then(res => res.json())
                    .then(data => {
                        const select = document.getElementById('word-topic-select');
                        select.innerHTML = '<option value="">-- Chọn chủ đề --</option>';
                        if (data.success && data.data) {
                            data.data.forEach(topic => {
                                select.innerHTML += `<option value="${topic.topic_id}">${topic.name} (${topic.topic_id})</option>`;
                            });
                        }
                    });
            }

            // Gửi form thêm Word
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('create-word-form');
                if (form) {
                    form.onsubmit = function(event) {
                        event.preventDefault(); // Ngăn chặn hành động mặc định của form
                        const formData = new FormData(form);
                        fetch('/word', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('word-form-message').innerText = 'Thêm Word thành công!';
                                form.reset();
                                setTimeout(() => {
                                    document.getElementById('add-word-form').style.display = 'none';
                                    document.getElementById('word-form-message').innerText = '';
                                    showData('word');
                                }, 1000); // Hiển thị thông báo thành công
                            } else {
                                document.getElementById('word-form-message').innerText = 'Lỗi: ' + data.error; // Hiển thị lỗi nếu có
                            }
                        })
                        .catch(() => {
                            document.getElementById('word-form-message').innerText = 'Lỗi kết nối. Vui lòng thử lại sau.';
                        });
                    }
                }
            })

            // Hàm sửa dữ liệu trong bảng
            function editData(table, id, secondId = null) {
                switch(table) {
                    case 'student':
                        showEditStudentForm(id);
                        break;
                    case 'student_progress':
                        showEditStudentProgressForm(id);
                        break;
                    case 'course':
                        showEditCourseForm(id);
                        break;
                    case 'topic':
                        showEditTopicForm(id);
                        break;
                    case 'learn_videos':
                        showEditLearnVideosForm(id);
                        break;
                    case 'practise_video':
                        showEditPractiseVideoForm(id);
                        break;
                    case 'word_practise_video':
                        showEditWordPractiseVideoForm(id);
                        break;
                    case 'enrolment':
                        showEditEnrolmentForm(id);
                        break;
                    case 'student_practise_video_record':
                        showEditStudentPractiseVideoRecordForm(id);
                        break;
                    case 'student_word_record':
                        showEditStudentWordRecordForm(id);
                        break;
                    case 'student_topic_record':
                        showEditStudentTopicRecordForm(id, secondId);
                        break;
                    case 'word':
                        showEditWordForm(id);
                        break;
                    default:
                        alert('Chức năng sửa dữ liệu chưa được hỗ trợ cho bảng này.');
                        break;
                }
            }

            // Hiển thị form sửa Student
            function showEditStudentForm(studentId) {
                // Lấy thông tin sinh viên từ server
                fetch(`/student/${studentId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit-student-form').style.display = 'block';
                        const form = document.getElementById('update-student-form');
                        form.student_id.value = data.student_id;
                        // form.email_address.value = data.email_address;
                        // form.password.value = '';
                        form.username.value = data.username || '';
                        form.age.value = data.age || '';
                        form.date_of_birth.value = data.date_of_birth || '';
                        form.gender.value = data.gender || '';
                        document.getElementById('edit-student-form-message').innerText = '';
                        // Gắn lại sự kiện submit
                        form.onsubmit = function(e) {
                            e.preventDefault();
                            const formData = new FormData(form);
                            fetch(`/student/${studentId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-HTTP-Method-Override': 'PUT'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(resp => {
                                if (resp.success) {
                                    document.getElementById('edit-student-form-message').innerText = 'Cập nhật thành công!';
                                    setTimeout(() => {
                                        document.getElementById('edit-student-form').style.display = 'none';
                                        document.getElementById('edit-student-form-message').innerText = '';
                                        showData('student');
                                    }, 1000);
                                } else {
                                    document.getElementById('edit-student-form-message').innerText = 'Lỗi: ' + (resp.message || 'Không thể cập nhật!');
                                }
                            })
                            .catch(() => {
                                document.getElementById('edit-student-form-message').innerText = 'Lỗi kết nối!';
                            });
                        }
                    });
            }

            // Hiển thị form sửa Student Progress
            function showEditStudentProgressForm(progressId) {
                //Lấy thông tin tuwf server
                fetch(`/student-progress/${progressId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit-student-progress-form').style.display = 'block';
                        const form = document.getElementById('update-student-progress-form');
                        if (data.success && data.data) {
                            const progress = data.data;
                            form.student_id.value = progress.student_id;
                            form.total_score.value = progress.total_score != null ? progress.total_score : 0;
                            form.word_score.value = progress.word_score != null ? progress.word_score : 0;
                            form.video_score.value = progress.video_score != null ? progress.video_score : 0;
                            form.level.value = progress.level != null ? progress.level : 1;
                        } else {
                            // Xử lý lỗi không tìm thấy
                            document.getElementById('edit-student-progress-form-message').innerText = data.message || 'Không tìm thấy dữ liệu!';
                        }
                        document.getElementById('edit-student-progress-form-message').innerText = '';
                        // Gắn lại sự kiện submit
                        form.onsubmit = function(e) {
                            e.preventDefault();
                            const formData = new FormData(form);
                            fetch(`/student-progress/${progressId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-HTTP-Method-Override': 'PUT'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(resp => {
                                if (resp.success) {
                                    document.getElementById('edit-student-progress-form-message').innerText = 'Cập nhật thành công!';
                                    setTimeout(() => {
                                        document.getElementById('edit-student-progress-form').style.display = 'none';
                                        document.getElementById('edit-student-progress-form-message').innerText = '';
                                        showData('student_progress');
                                    }, 1000);
                                } else {
                                    document.getElementById('edit-student-progress-form-message').innerText = 'Lỗi: ' + (resp.message || 'Không thể cập nhật!');
                                }
                            })
                            .catch(() => {
                                document.getElementById('edit-student-progress-form-message').innerText = 'Lỗi kết nối!';
                            });
                        }
                    });
            }

            // Hiển thị form sửa Course
            function showEditCourseForm(courseId) {
                // Lấy thông tin khóa học từ server
                fetch(`/course/${courseId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit-course-form').style.display = 'block';
                        const form = document.getElementById('update-course-form');
                        if (data.success && data.data) {
                            const course = data.data;
                            form.course_id.value = course.course_id;
                            form.nation.value = course.nation;
                            form.total_topic.value = course.total_topic;
                        } else {
                            document.getElementById('edit-course-form-message').innerText = data.message || 'Không tìm thấy dữ liệu!';
                        }
                        document.getElementById('edit-course-form-message').innerText = '';
                        // Gắn lại sự kiện submit
                        form.onsubmit = function(e) {
                            e.preventDefault();
                            const formData = new FormData(form);
                            fetch(`/course/${courseId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-HTTP-Method-Override': 'PUT'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(resp => {
                                if (resp.success) {
                                    document.getElementById('edit-course-form-message').innerText = 'Cập nhật thành công!';
                                    setTimeout(() => {
                                        document.getElementById('edit-course-form').style.display = 'none';
                                        document.getElementById('edit-course-form-message').innerText = '';
                                        showData('course');
                                    }, 1000);
                                } else {
                                    document.getElementById('edit-course-form-message').innerText = 'Lỗi: ' + (resp.message || 'Không thể cập nhật!');
                                }
                            })
                            .catch(() => {
                                document.getElementById('edit-course-form-message').innerText = 'Lỗi kết nối!';
                            });
                        }
                    });
            }
            // Hiển thị form sửa Topic
            function showEditTopicForm(topicId) {
                // Lấy thông tin topic từ server
                fetch(`/topic/${topicId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit-topic-form').style.display = 'block';
                        const form = document.getElementById('update-topic-form');
                        if (data.success && data.data) {
                            const topic = data.data;
                            // Lấy danh sách khóa học để hiển thị trong dropdown
                            fetch('/courses')
                                .then(res => res.json())
                                .then(coursesData => {
                                    const select = document.getElementById('edit-topic-course-select');
                                    select.innerHTML = '<option value="">-- Chọn khóa học --</option>';
                                    if (coursesData.success && coursesData.data) {
                                        coursesData.data.forEach(course => {
                                            select.innerHTML += `<option value="${course.course_id}" ${course.course_id === topic.course_id ? 'selected' : ''}>${course.nation} (${course.course_id})</option>`;
                                        });
                                    }
                                });
                            form.topic_id.value = topic.topic_id;
                            form.name.value = topic.name;
                            form.level.value = topic.level;
                            form.number_of_word.value = topic.number_of_word;
                        } else {
                            document.getElementById('edit-topic-form-message').innerText = data.message || 'Không tìm thấy dữ liệu!';
                        }
                        document.getElementById('edit-topic-form-message').innerText = '';
                        // Gắn lại sự kiện submit
                        form.onsubmit = function(e) {
                            e.preventDefault();
                            const formData = new FormData(form);
                            fetch(`/topic/${topicId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-HTTP-Method-Override': 'PUT'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(resp => {
                                if (resp.success) {
                                    document.getElementById('edit-topic-form-message').innerText = 'Cập nhật thành công!';
                                    setTimeout(() => {
                                        document.getElementById('edit-topic-form').style.display = 'none';
                                        document.getElementById('edit-topic-form-message').innerText = '';
                                        showData('topic');
                                    }, 1000);
                                } else {
                                    document.getElementById('edit-topic-form-message').innerText = 'Lỗi: ' + (resp.message || 'Không thể cập nhật!');
                                }
                            })
                            .catch(() => {
                                document.getElementById('edit-topic-form-message').innerText = 'Lỗi kết nối!';
                            });
                        }
                    });
            }

            // Hiển thị form sửa Learn Videos
            function showEditLearnVideosForm(videoId) {
                // Lấy thông tin video từ server
                fetch(`/learn-video/${videoId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit-learn-videos-form').style.display = 'block';
                        const form = document.getElementById('update-learn-videos-form');
                        if (data.success && data.data) {
                            const video = data.data;
                            // Lấy danh sách từ (words) để hiển thị trong dropdown
                            fetch('/words')
                                .then(res => res.json())
                                .then(wordsData => {
                                    const select = document.getElementById('edit-learn-videos-word-select');
                                    select.innerHTML = '<option value="">-- Chọn từ --</option>';
                                    if (wordsData.success && wordsData.data) {
                                        wordsData.data.forEach(word => {
                                            select.innerHTML += `<option value="${word.word_id}" ${word.word_id === video.word_id ? 'selected' : ''}>${word.word} (${word.word_id})</option>`;
                                        });
                                    }
                                });
                            form.learn_video_id.value = video.learn_video_id;
                            form.word_id.value = video.word_id;
                            form.video_url.value = video.video_url;
                        } else {
                            document.getElementById('edit-learn-videos-form-message').innerText = data.message || 'Không tìm thấy dữ liệu!';
                        }
                        document.getElementById('edit-learn-videos-form-message').innerText = '';
                        // Gắn lại sự kiện submit
                        form.onsubmit = function(e) {
                            e.preventDefault(); // Ngăn chặn hành động mặc định của form
                            const formData = new FormData(form);
                            fetch(`/learn-video/${videoId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-HTTP-Method-Override': 'PUT'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(resp => {
                                if (resp.success) {
                                    document.getElementById('edit-learn-videos-form-message').innerText = 'Cập nhật thành công!';
                                    setTimeout(() => {
                                        document.getElementById('edit-learn-videos-form').style.display = 'none';
                                        document.getElementById('edit-learn-videos-form-message').innerText = '';
                                        showData('learn_videos'); // Tùy theo tên bảng của bạn
                                    }, 1000);
                                } else {
                                    document.getElementById('edit-learn-videos-form-message').innerText = 'Lỗi: ' + (resp.message || 'Không thể cập nhật!');
                                }
                            })
                            .catch(() => {
                                document.getElementById('edit-learn-videos-form-message').innerText = 'Lỗi kết nối!';
                            });
                        }
                    });
            }

            // Hiển thị form sửa Practise Video
            function showEditPractiseVideoForm(videoId) {
                // Lấy thông tin video từ server
                fetch(`/practise-video/${videoId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit-practise-video-form').style.display = 'block';
                        const form = document.getElementById('update-practise-video-form');
                        if (data.success && data.data) {
                            const video = data.data;
                            // Lấy danh sách khóa học để hiển thị trong dropdown
                            fetch('/courses')
                                .then(res => res.json())
                                .then(coursesData => {
                                    const select = document.getElementById('edit-practise-video-course-select');
                                    select.innerHTML = '<option value="">-- Chọn khóa học --</option>';
                                    if (coursesData.success && coursesData.data) {
                                        coursesData.data.forEach(course => {
                                            select.innerHTML += `<option value="${course.course_id}" ${course.course_id === video.course_id ? 'selected' : ''}>${course.nation} (${course.course_id})</option>`;
                                        });
                                    }
                                });
                            form.practise_video_id.value = video.practise_video_id;
                            form.course_id.value = video.course_id;
                            form.video_link.value = video.video_link;
                            form.subtitle.value = video.subtitle;
                            form.score.value = video.score;
                        } else {
                            document.getElementById('edit-practise-video-form-message').innerText = data.message || 'Không tìm thấy dữ liệu!';
                        }
                        document.getElementById('edit-practise-video-form-message').innerText = '';
                        // Gắn lại sự kiện submit
                        form.onsubmit = function(e) {
                            e.preventDefault(); // Ngăn chặn hành động mặc định của form
                            const formData = new FormData(form);
                            fetch(`/practise-video/${videoId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-HTTP-Method-Override': 'PUT'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(resp => {
                                if (resp.success) {
                                    document.getElementById('edit-practise-video-form-message').innerText = 'Cập nhật thành công!';
                                    setTimeout(() => {
                                        document.getElementById('edit-practise-video-form').style.display = 'none';
                                        document.getElementById('edit-practise-video-form-message').innerText = '';
                                        showData('practise_video'); // Tùy theo tên bảng của bạn
                                    }, 1000);
                                } else {
                                    document.getElementById('edit-practise-video-form-message').innerText = 'Lỗi: ' + (resp.message || 'Không thể cập nhật!');
                                }
                            })
                            .catch(() => {
                                document.getElementById('edit-practise-video-form-message').innerText = 'Lỗi kết nối!';
                            });
                        }
                    });
            }
            // Hiển thị form sửa Word Practise Video
            function showEditWordPractiseVideoForm(videoId) {
                // Lấy thông tin video từ server
                fetch(`/word-practise-video/${videoId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit-word-practise-video-form').style.display = 'block';
                        const form = document.getElementById('update-word-practise-video-form');
                        if (data.success && data.data) {
                            const video = data.data;
                            // Lấy danh sách từ để hiển thị trong dropdown
                            fetch('/words')
                                .then(res => res.json())
                                .then(wordsData => {
                                    const wordSelect = document.getElementById('edit-word-practise-video-word-select');
                                    wordSelect.innerHTML = '<option value="">-- Chọn từ --</option>';
                                    if (wordsData.success && wordsData.data) {
                                        wordsData.data.forEach(word => {
                                            wordSelect.innerHTML += `<option value="${word.word_id}" ${word.word_id === video.word_id ? 'selected' : ''}>${word.word} (${word.word_id})</option>`;
                                        });
                                    }
                                });
                            // Lấy danh sách video thực hành để hiển thị trong dropdown
                            fetch('/practise-videos')
                                .then(res => res.json())
                                .then(videosData => {
                                    const videoSelect = document.getElementById('edit-word-practise-video-video-select');
                                    videoSelect.innerHTML = '<option value="">-- Chọn video thực hành --</option>';
                                    if (videosData.success && videosData.data) {
                                        videosData.data.forEach(video => {
                                            videoSelect.innerHTML += `<option value="${video.practise_video_id}" ${video.practise_video_id === video.practise_video_id ? 'selected' : ''}>${video.video_link} (${video.practise_video_id})</option>`;
                                        });
                                    }
                                });
                            form.word_practise_video_id.value = video.word_practise_video_id;
                            form.word_id.value = video.word_id;
                            form.practise_video_id.value = video.practise_video_id;
                        } else {
                            document.getElementById('edit-word-practise-video-form-message').innerText = data.message || 'Không tìm thấy dữ liệu!';
                        }
                        document.getElementById('edit-word-practise-video-form-message').innerText = '';
                        // Gắn lại sự kiện submit
                        form.onsubmit = function(e) {
                            e.preventDefault(); // Ngăn chặn hành động mặc định của form
                            const formData = new FormData(form);
                            fetch(`/word-practise-video/${videoId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-HTTP-Method-Override': 'PUT'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(resp => {
                                if (resp.success) {
                                    document.getElementById('edit-word-practise-video-form-message').innerText = 'Cập nhật thành công!';
                                    setTimeout(() => {
                                        document.getElementById('edit-word-practise-video-form').style.display = 'none';
                                        document.getElementById('edit-word-practise-video-form-message').innerText = '';
                                        showData('word_practise_video'); // Tùy theo tên bảng của bạn
                                    }, 1000);
                                } else {
                                    document.getElementById('edit-word-practise-video-form-message').innerText = 'Lỗi: ' + (resp.message || 'Không thể cập nhật!');
                                }
                            })
                            .catch(() => {
                                document.getElementById('edit-word-practise-video-form-message').innerText = 'Lỗi kết nối!';
                            });
                        }
                    });
            }
            // Hiển thị form sửa Enrolment
            function showEditEnrolmentForm(enrolmentId) {
                // Lấy thông tin đăng ký từ server
                fetch(`/enrolment/${enrolmentId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit-enrolment-form').style.display = 'block';
                        const form = document.getElementById('update-enrolment-form');
                        if (data.success && data.data) {
                            const enrolment = data.data;
                            // Lấy danh sách sinh viên để hiển thị trong dropdown
                            fetch('/students')
                                .then(res => res.json())
                                .then(studentsData => {
                                    const studentSelect = document.getElementById('edit-enrolment-student-select');
                                    studentSelect.innerHTML = '<option value="">-- Chọn sinh viên --</option>';
                                    if (studentsData.success && studentsData.data) {
                                        studentsData.data.forEach(student => {
                                            studentSelect.innerHTML += `<option value="${student.student_id}" ${student.student_id === enrolment.student_id ? 'selected' : ''}>${student.username} (${student.student_id})</option>`;
                                        });
                                    }
                                });
                            // Lấy danh sách khóa học để hiển thị trong dropdown
                            fetch('/courses')
                                .then(res => res.json())
                                .then(coursesData => {
                                    const courseSelect = document.getElementById('edit-enrolment-course-select');
                                    courseSelect.innerHTML = '<option value="">-- Chọn khóa học --</option>';
                                    if (coursesData.success && coursesData.data) {
                                        coursesData.data.forEach(course => {
                                            courseSelect.innerHTML += `<option value="${course.course_id}" ${course.course_id === enrolment.course_id ? 'selected' : ''}>${course.nation} (${course.course_id})</option>`;
                                        });
                                    }
                                });
                            form.enrolment_id.value = enrolment.enrolment_id;
                            form.student_id.value = enrolment.student_id;
                            form.course_id.value = enrolment.course_id;
                            form.enrolment_datetime.value= enrolment.enrolment_datetime;
                            form.is_completed.value = enrolment.is_completed;
                        } else {
                            document.getElementById('edit-enrolment-form-message').innerText = data.message || 'Không tìm thấy dữ liệu!';
                        }
                        document.getElementById('edit-enrolment-form-message').innerText = '';
                        // Gắn lại sự kiện submit
                        form.onsubmit = function(e) {
                            e.preventDefault(); // Ngăn chặn hành động mặc định của form
                            const formData = new FormData(form);
                            fetch(`/enrolment/${enrolmentId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-HTTP-Method-Override': 'PUT'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(resp => {
                                if (resp.success) {
                                    document.getElementById('edit-enrolment-form-message').innerText = 'Cập nhật thành công!';
                                    setTimeout(() => {
                                        document.getElementById('edit-enrolment-form').style.display = 'none';
                                        document.getElementById('edit-enrolment-form-message').innerText = '';
                                        showData('enrolment'); // Tùy theo tên bảng của bạn
                                    }, 1000);
                                } else {
                                    document.getElementById('edit-enrolment-form-message').innerText = 'Lỗi: ' + (resp.message || 'Không thể cập nhật!');
                                }
                            })
                            .catch(() => {
                                document.getElementById('edit-enrolment-form-message').innerText = 'Lỗi kết nối!';
                            });
                        }
                    });
            }

            // Hiển thị form sửa student practise video Record
            function showEditStudentPractiseVideoRecordForm(recordId) {
                // Lấy thông tin từ server
                fetch(`/student-practise-video-record/${recordId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit-student-practise-video-record-form').style.display = 'block';
                        const form = document.getElementById('update-student-practise-video-record-form');
                        if (data.success && data.data) {
                            const record = data.data;
                            // Lấy danh sách sinh viên để hiển thị trong dropdown
                            fetch('/students')
                                .then(res => res.json())
                                .then(studentsData => {
                                    const select = document.getElementById('edit-student-practise-video-record-student-select');
                                    select.innerHTML = '<option value="">-- Chọn sinh viên --</option>';
                                    if (studentsData.success && studentsData.data) {
                                        studentsData.data.forEach(student => {
                                            select.innerHTML += `<option value="${student.student_id}" ${student.student_id === record.student_id ? 'selected' : ''}>${student.username} (${student.student_id})</option>`;
                                        });
                                    }
                                });
                            // Lấy danh sách video thực hành để hiển thị trong dropdown
                            fetch('/practise-videos')
                                .then(res => res.json())
                                .then(videosData => {
                                    const videoSelect = document.getElementById('edit-student-practise-video-record-video-select');
                                    videoSelect.innerHTML = '<option value="">-- Chọn video thực hành --</option>';
                                    if (videosData.success && videosData.data) {
                                        videosData.data.forEach(video => {
                                            videoSelect.innerHTML += `<option value="${video.practise_video_id}" ${video.practise_video_id === record.practise_video_id ? 'selected' : ''}>${video.video_link} (${video.practise_video_id})</option>`;
                                        });
                                    }
                                });
                            form.student_practise_video_record_id.value = record.student_practise_video_record_id;
                            form.student_id.value = record.student_id;
                            form.practise_video_id.value = record.practise_video_id;
                            form.is_learned.value = record.is_learned || 0; // Đảm bảo is_learned luôn có giá trị
                            form.replay_time.value = record.replay_time || 0; // Đảm bảo replaay_time luôn có giá trị
                            form.is_mastered.value = record.is_mastered || 0; // Đảm bảo is_mastered luôn có giá trị
                        } else {
                            document.getElementById('edit-student-practise-video-record-form-message').innerText = data.message || 'Không tìm thấy dữ liệu!';
                        }
                        document.getElementById('edit-student-practise-video-record-form-message').innerText = '';
                        // Gắn lại sự kiện submit
                        form.onsubmit = function(e) {
                            e.preventDefault(); // Ngăn chặn hành động mặc định của form
                            const formData = new FormData(form);
                            fetch(`/student-practise-video-record/${recordId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-HTTP-Method-Override': 'PUT'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(resp => {
                                if (resp.success) {
                                    document.getElementById('edit-student-practise-video-record-form-message').innerText = 'Cập nhật thành công!';
                                    setTimeout(() => {
                                        document.getElementById('edit-student-practise-video-record-form').style.display = 'none';
                                        document.getElementById('edit-student-practise-video-record-form-message').innerText = '';
                                        showData('student_practise_video_record'); // Tùy theo tên bảng của bạn
                                    }, 1000);
                                } else {
                                    document.getElementById('edit-student-practise-video-record-form-message').innerText = 'Lỗi: ' + (resp.message || 'Không thể cập nhật!');
                                }
                            })
                            .catch(() => {
                                document.getElementById('edit-student-practise-video-record-form-message').innerText = 'Lỗi kết nối!';
                            });
                        }
                    });
            }

            // Hiển thị form sửa student word record
            function showEditStudentWordRecordForm(recordId) {
                // Lấy thông tin từ server
                fetch(`/student-word-record/${recordId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit-student-word-record-form').style.display = 'block';
                        const form = document.getElementById('update-student-word-record-form');
                        if (data.success && data.data) {
                            const record = data.data;
                            // Lấy danh sách sinh viên để hiển thị trong dropdown
                            fetch('/students')
                                .then(res => res.json())
                                .then(studentsData => {
                                    const select = document.getElementById('edit-student-word-record-student-select');
                                    select.innerHTML = '<option value="">-- Chọn sinh viên --</option>';
                                    if (studentsData.success && studentsData.data) {
                                        studentsData.data.forEach(student => {
                                            select.innerHTML += `<option value="${student.student_id}" ${student.student_id === record.student_id ? 'selected' : ''}>${student.username} (${student.student_id})</option>`;
                                        });
                                    }
                                });
                            // Lấy danh sách từ để hiển thị trong dropdown
                            fetch('/words')
                                .then(res => res.json())
                                .then(wordsData => {
                                    const wordSelect = document.getElementById('edit-student-word-record-word-select');
                                    wordSelect.innerHTML = '<option value="">-- Chọn từ --</option>';
                                    if (wordsData.success && wordsData.data) {
                                        wordsData.data.forEach(word => {
                                            wordSelect.innerHTML += `<option value="${word.word_id}" ${word.word_id === record.word_id ? 'selected' : ''}>${word.word} (${word.word_id})</option>`;
                                        });
                                    }
                                });
                            form.student_word_record_id.value = record.student_word_record_id;
                            form.student_id.value = record.student_id;
                            form.word_id.value = record.word_id;
                            form.is_learned.value = record.is_learned || 0; // Đảm bảo is_learned luôn có giá trị
                            form.replay_time.value = record.replay_time || 0; // Đảm bảo replay_time luôn có giá trị
                            form.is_mastered.value = record.is_mastered || 0; // Đảm bảo is_mastered luôn có giá trị
                        } else {
                            document.getElementById('edit-student-word-record-form-message').innerText = data.message || 'Không tìm thấy dữ liệu!';
                        }
                        document.getElementById('edit-student-word-record-form-message').innerText = '';
                        // Gắn lại sự kiện submit
                        form.onsubmit = function(e) {
                            e.preventDefault(); // Ngăn chặn hành động mặc định của form
                            const formData = new FormData(form);
                            fetch(`/student-word-record/${recordId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-HTTP-Method-Override': 'PUT'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(resp => {
                                if (resp.success) {
                                    document.getElementById('edit-student-word-record-form-message').innerText = 'Cập nhật thành công!';
                                    setTimeout(() => {
                                        document.getElementById('edit-student-word-record-form').style.display = 'none';
                                        document.getElementById('edit-student-word-record-form-message').innerText = '';
                                        showData('student_word_record'); // Tùy theo tên bảng của bạn
                                    }, 1000);
                                } else {
                                    document.getElementById('edit-student-word-record-form-message').innerText = 'Lỗi: ' + (resp.message || 'Không thể cập nhật!');
                                }
                            })
                            .catch(() => {
                                document.getElementById('edit-student-word-record-form-message').innerText = 'Lỗi kết nối!';
                            });
                        }
                    });
            }
            //Hiển thị form sửa student topic Record
            function showEditStudentTopicRecordForm(studentId, topicId) {
                // Lấy thông tin từ server
                fetch(`/student-topic-record/${studentId}/${topicId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit-student-topic-record-form').style.display = 'block';
                        const form = document.getElementById('update-student-topic-record-form');
                        if (data.success && data.data) {
                            const record = data.data;
                            // Lấy danh sách sinh viên để hiển thị trong dropdown
                            fetch('/students')
                                .then(res => res.json())
                                .then(studentsData => {
                                    const select = document.getElementById('edit-student-topic-record-student-select');
                                    select.innerHTML = '<option value="">-- Chọn sinh viên --</option>';
                                    if (studentsData.success && studentsData.data) {
                                        studentsData.data.forEach(student => {
                                            select.innerHTML += `<option value="${student.student_id}" ${student.student_id === record.student_id ? 'selected' : ''}>${student.username} (${student.student_id})</option>`;
                                        });
                                    }
                                });
                            // Lấy danh sách chủ đề để hiển thị trong dropdown
                            fetch('/topics')
                                .then(res => res.json())
                                .then(topicsData => {
                                    const topicSelect = document.getElementById('edit-student-topic-record-topic-select');
                                    topicSelect.innerHTML = '<option value="">-- Chọn chủ đề --</option>';
                                    if (topicsData.success && topicsData.data) {
                                        topicsData.data.forEach(topic => {
                                            topicSelect.innerHTML += `<option value="${topic.topic_id}" ${topic.topic_id === record.topic_id ? 'selected' : ''}>${topic.topic_name} (${topic.topic_id})</option>`;
                                        });
                                    }
                                });
                            // form.student_topic_record_id.value = record.student_topic_record_id;
                            form.student_id.value = record.student_id;
                            form.topic_id.value = record.topic_id;
                            form.is_completed.value = record.is_completed || 0; // Đảm bảo is_learned luôn có giá tri
                        } else {
                            document.getElementById('edit-student-topic-record-form-message').innerText = data.message || 'Không tìm thấy dữ liệu!';
                        }
                        document.getElementById('edit-student-topic-record-form-message').innerText = '';
                        // Gắn lại sự kiện submit
                        form.onsubmit = function(e) {
                            e.preventDefault(); // Ngăn chặn hành động mặc định của form
                            const formData = new FormData(form);
                            fetch(`/student-topic-record/${studentId}/${topicId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-HTTP-Method-Override': 'PUT'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(resp => {
                                if (resp.success) {
                                    document.getElementById('edit-student-topic-record-form-message').innerText = 'Cập nhật thành công!';
                                    setTimeout(() => {
                                        document.getElementById('edit-student-topic-record-form').style.display = 'none';
                                        document.getElementById('edit-student-topic-record-form-message').innerText = '';
                                        showData('student_topic_record'); // Tùy theo tên bảng của bạn
                                    }, 1000);
                                } else {
                                    document.getElementById('edit-student-topic-record-form-message').innerText = 'Lỗi: ' + (resp.message || 'Không thể cập nhật!');
                                }
                            })
                            .catch(() => {
                                document.getElementById('edit-student-topic-record-form-message').innerText = 'Lỗi kết nối!';
                            });
                        }
                    });
            }

            // Hiển thị form sửa Word
            function showEditWordForm(wordId) {
                // Lấy thông tin từ server
                fetch(`/word/${wordId}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('edit-word-form').style.display = 'block';
                        const form = document.getElementById('update-word-form');
                        if (data.success && data.data) {
                            const word = data.data;
                            fetch('/topics')
                                .then(res => res.json())
                                .then(topicsData => {
                                    const select = document.getElementById('edit-word-topic-select');
                                    select.innerHTML = '<option value="">-- Chọn chủ đề --</option>';
                                    if (topicsData.success && topicsData.data) {
                                        topicsData.data.forEach(topic => {
                                            select.innerHTML += `<option value="${topic.topic_id}" ${topic.topic_id === word.topic_id ? 'selected' : ''}>${topic.name} (${topic.topic_id})</option>`;
                                        });
                                    }
                                });
                            form.word_id.value = word.word_id;
                            form.word.value = word.word;
                            form.meaning.value = word.meaning;
                            form.score.value = word.score || 0; // Đảm bảo score luôn có giá trị
                        } else {
                            document.getElementById('edit-word-form-message').innerText = data.message || 'Không tìm thấy dữ liệu!';
                        }
                        document.getElementById('edit-word-form-message').innerText = '';
                        // Gắn lại sự kiện submit
                        form.onsubmit = function(e) {
                            e.preventDefault(); // Ngăn chặn hành động mặc định của form
                            const formData = new FormData(form);
                            fetch(`/word/${wordId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'X-HTTP-Method-Override': 'PUT'
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(resp => {
                                if (resp.success) {
                                    document.getElementById('edit-word-form-message').innerText = 'Cập nhật thành công!';
                                    setTimeout(() => {
                                        document.getElementById('edit-word-form').style.display = 'none';
                                        document.getElementById('edit-word-form-message').innerText = '';
                                        showData('word'); // Tùy theo tên bảng của bạn
                                    }, 1000);
                                } else {
                                    document.getElementById('edit-word-form-message').innerText = 'Lỗi: ' + (resp.message || 'Không thể cập nhật!');
                                }
                            })
                            .catch(() => {
                                document.getElementById('edit-word-form-message').innerText = 'Lỗi kết nối!';
                            });
                        }
                    });
            }


            //Xóa dữ liệu
            let deleteTable = '';
            let deleteId = '';
            let deleteStudentId = '';
            let deleteTopicId = '';
            function deleteData(table, id, secondId = null) {
                switch(table) {
                    case 'student':
                        deleteTable = table;
                        deleteId = id;
                        document.getElementById('delete-student-form').style.display = 'block';
                        document.getElementById('delete-student-form-message').innerText = '';
                        break;
                    case 'course':
                        deleteTable = table;
                        deleteId = id;
                        document.getElementById('delete-course-form').style.display = 'block';
                        document.getElementById('delete-course-form-message').innerText = '';
                        break;
                    case 'topic':
                        deleteTable = table;
                        deleteId = id;
                        document.getElementById('delete-topic-form').style.display = 'block';
                        document.getElementById('delete-topic-form-message').innerText = '';
                        break;
                    case 'learn_videos':
                        deleteTable = table;
                        deleteId = id;
                        document.getElementById('delete-learn-videos-form').style.display = 'block';
                        document.getElementById('delete-learn-videos-form-message').innerText = '';
                        break;
                    case 'practise_video':
                        deleteTable = table;
                        deleteId = id;
                        document.getElementById('delete-practise-video-form').style.display = 'block';
                        document.getElementById('delete-practise-video-form-message').innerText = '';
                        break;
                    case 'word_practise_video':
                        deleteTable = table;
                        deleteId = id;
                        document.getElementById('delete-word-practise-video-form').style.display = 'block';
                        document.getElementById('delete-word-practise-video-form-message').innerText = '';
                        break;
                    case 'enrolment':
                        deleteTable = table;
                        deleteId = id;
                        document.getElementById('delete-enrolment-form').style.display = 'block';
                        document.getElementById('delete-enrolment-form-message').innerText = '';
                        break;
                    case 'student_practise_video_record':
                        deleteTable = table;
                        deleteId = id;
                        document.getElementById('delete-student-practise-video-record-form').style.display = 'block';
                        document.getElementById('delete-student-practise-video-record-form-message').innerText = '';
                        break;
                    case 'student_word_record':
                        deleteTable = table;
                        deleteId = id;
                        document.getElementById('delete-student-word-record-form').style.display = 'block';
                        document.getElementById('delete-student-word-record-form-message').innerText = '';
                        break;
                    case 'student_topic_record':
                        deleteTable = table;
                        deleteStudentId = id;
                        deleteTopicId = secondId;
                        document.getElementById('delete-student-topic-record-form').style.display = 'block';
                        document.getElementById('delete-student-topic-record-form-message').innerText = '';
                        break;
                    case 'word':
                        deleteTable = table;
                        deleteId = id;
                        document.getElementById('delete-word-form').style.display = 'block';
                        document.getElementById('delete-word-form-message').innerText = '';
                        break;
                    default:
                        alert('Chức năng xóa dữ liệu chưa được hỗ trợ cho bảng này.');
                        break;
                }
            }

            // Đóng popup xóa Student
            function closeDeleteStudentPopup() {
                document.getElementById('delete-student-form').style.display = 'none';
                deleteTable = '';
                deleteId = '';
            }

            // Xác nhận xóa Student
            function confirmDeleteStudent() {
                fetch(`/student/${deleteId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showData(deleteTable);
                        closeDeleteStudentPopup();
                    } else {
                        document.getElementById('delete-student-form-message').innerText = data.message || 'Xóa thất bại!';
                    }
                })
                .catch(() => {
                    document.getElementById('delete-student-form-message').innerText = 'Lỗi kết nối!';
                });
            }

            // Đóng popup xóa Course
            function closeDeleteCoursePopup() {
                document.getElementById('delete-course-form').style.display = 'none';
                deleteTable = '';
                deleteId = '';
            }

            // Xác nhận xóa Course
            function confirmDeleteCourse() {
                fetch(`/course/${deleteId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showData(deleteTable);
                        closeDeleteCoursePopup();
                    } else {
                        document.getElementById('delete-course-form-message').innerText = data.message || 'Xóa thất bại!';
                    }
                })
                .catch(() => {
                    document.getElementById('delete-course-form-message').innerText = 'Lỗi kết nối!';
                });
            }

            // Đóng popup xóa Topic
            function closeDeleteTopicPopup() {
                document.getElementById('delete-topic-form').style.display = 'none';
                deleteTable = '';
                deleteId = '';
            }

            // Xác nhận xóa Topic
            function confirmDeleteTopic() {
                fetch(`/topic/${deleteId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showData(deleteTable);
                        closeDeleteTopicPopup();
                    } else {
                        document.getElementById('delete-topic-form-message').innerText = data.message || 'Xóa thất bại!';
                    }
                })
                .catch(() => {
                    document.getElementById('delete-topic-form-message').innerText = 'Lỗi kết nối!';
                });
            }

            // Đóng popup xóa Learn Videos
            function closeDeleteLearnVideosPopup() {
                document.getElementById('delete-learn-videos-form').style.display = 'none';
                deleteTable = '';
                deleteId = '';
            }

            // Xác nhận xóa Learn Videos
            function confirmDeleteLearnVideos() {
                fetch(`/learn-video/${deleteId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showData(deleteTable);
                        closeDeleteLearnVideosPopup();
                    } else {
                        document.getElementById('delete-learn-videos-form-message').innerText = data.message || 'Xóa thất bại!';
                    }
                })
                .catch(() => {
                    document.getElementById('delete-learn-videos-form-message').innerText = 'Lỗi kết nối!';
                });
            }

            // Đóng popup xóa Practise Video
            function closeDeletePractiseVideoPopup() {
                document.getElementById('delete-practise-video-form').style.display = 'none';
                deleteTable = '';
                deleteId = '';
            }

            // Xác nhận xóa Practise Video
            function confirmDeletePractiseVideo() {
                fetch(`/practise-video/${deleteId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showData(deleteTable);
                        closeDeletePractiseVideoPopup();
                    } else {
                        document.getElementById('delete-practise-video-form-message').innerText = data.message || 'Xóa thất bại!';
                    }
                })
                .catch(() => {
                    document.getElementById('delete-practise-video-form-message').innerText = 'Lỗi kết nối!';
                });
            }
            // Đóng popup xóa Word Practise Video
            function closeDeleteWordPractiseVideoPopup() {
                document.getElementById('delete-word-practise-video-form').style.display = 'none';
                deleteTable = '';
                deleteId = '';
            }

            // Xác nhận xóa Word Practise Video
            function confirmDeleteWordPractiseVideo() {
                fetch(`/word-practise-video/${deleteId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showData(deleteTable);
                        closeDeleteWordPractiseVideoPopup();
                    } else {
                        document.getElementById('delete-word-practise-video-form-message').innerText = data.message || 'Xóa thất bại!';
                    }
                })
                .catch(() => {
                    document.getElementById('delete-word-practise-video-form-message').innerText = 'Lỗi kết nối!';
                });
            }

            // Đóng popup xóa Enrolment
            function closeDeleteEnrolmentPopup() {
                document.getElementById('delete-enrolment-form').style.display = 'none';
                deleteTable = '';
                deleteId = '';
            }

            // Xác nhận xóa Enrolment
            function confirmDeleteEnrolment() {
                fetch(`/enrolment/${deleteId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showData(deleteTable);
                        closeDeleteEnrolmentPopup();
                    } else {
                        document.getElementById('delete-enrolment-form-message').innerText = data.message || 'Xóa thất bại!';
                    }
                })
                .catch(() => {
                    document.getElementById('delete-enrolment-form-message').innerText = 'Lỗi kết nối!';
                });
            }

            //Hiển thị form xóa Student Practise Video Record
            function closeDeleteStudentPractiseVideoRecordPopup() {
                document.getElementById('delete-student-practise-video-record-form').style.display = 'none';
                deleteTable = '';
                deleteId = '';
            }

            // Xác nhận xóa Student Practise Video Record
            function confirmDeleteStudentPractiseVideoRecord() {
                fetch(`/student-practise-video-record/${deleteId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showData(deleteTable);
                        closeDeleteStudentPractiseVideoRecordPopup();
                    } else {
                        document.getElementById('delete-student-practise-video-record-form-message').innerText = data.message || 'Xóa thất bại!';
                    }
                })
                .catch(() => {
                    document.getElementById('delete-student-practise-video-record-form-message').innerText = 'Lỗi kết nối!';
                });
            }
            //Hiển thị form xóa Student Word Record
            function closeDeleteStudentWordRecordPopup() {
                document.getElementById('delete-student-word-record-form').style.display = 'none';
                deleteTable = '';
                deleteId = '';
            }

            // Xác nhận xóa Student Word Record
            function confirmDeleteStudentWordRecord() {
                fetch(`/student-word-record/${deleteId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showData(deleteTable);
                        closeDeleteStudentWordRecordPopup();
                    } else {
                        document.getElementById('delete-student-word-record-form-message').innerText = data.message || 'Xóa thất bại!';
                    }
                })
                .catch(() => {
                    document.getElementById('delete-student-word-record-form-message').innerText = 'Lỗi kết nối!';
                });
            }
            //Hiển thị form xóa Student Topic Record
            function closeDeleteStudentTopicRecordPopup() {
                document.getElementById('delete-student-topic-record-form').style.display = 'none';
                deleteTable = '';
                deleteId = '';
            }
            // Xác nhận xóa Student Topic Record
            function confirmDeleteStudentTopicRecord() {
                fetch(`/student-topic-record/${deleteStudentId}/${deleteTopicId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showData(deleteTable);
                        closeDeleteStudentTopicRecordPopup();
                    } else {
                        document.getElementById('delete-student-topic-record-form-message').innerText = data.message || 'Xóa thất bại!';
                    }
                })
                .catch(() => {
                    document.getElementById('delete-student-topic-record-form-message').innerText = 'Lỗi kết nối!';
                });
            }

            //Đóng popup xóa Word
            function closeDeleteWordPopup() {
                document.getElementById('delete-word-form').style.display = 'none';
                deleteTable = '';
                deleteId = '';
            }

            // Xác nhận xóa Word
            function confirmDeleteWord() {
                fetch(`/word/${deleteId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showData(deleteTable);
                        closeDeleteWordPopup();
                    } else {
                        document.getElementById('delete-word-form-message').innerText = data.message || 'Xóa thất bại!';
                    }
                })
                .catch(() => {
                    document.getElementById('delete-word-form-message').innerText = 'Lỗi kết nối!';
                });
            }
        </script>
        {{-- Include các popup --}}

        {{-- Include các popup Student Progress --}}
        {{-- @include('popup.add-student-progress-form') --}}
        @include('popup.edit-student-progress-form')
        {{-- @include('popup.delete-student-progress-form') --}}

        {{-- Include các popup Student Topic Record --}}
        @include('popup.add-student-topic-record-form')
        @include('popup.edit-student-topic-record-form')
        @include('popup.delete-student-topic-record-form')

        {{--Include các popup student word record--}}
        @include('popup.add-student-word-record-form')
        @include('popup.edit-student-word-record-form')
        @include('popup.delete-student-word-record-form')


        {{-- Include các popup Student --}}
        @include('popup.add-student-form')
        @include('popup.edit-student-form')
        @include('popup.delete-student-form')




        {{-- Include các popup Practise Video --}}
        @include('popup.add-practise-video-form')
        @include('popup.edit-practise-video-form')
        @include('popup.delete-practise-video-form')

        {{--Include các popup Learn Video--}}
        @include('popup.add-learn-videos-form')
        @include('popup.edit-learn-videos-form')
        @include('popup.delete-learn-videos-form')

        {{-- Include các popup Topic --}}
        @include('popup.add-topic-form')
        @include('popup.edit-topic-form')
        @include('popup.delete-topic-form')

        {{-- Include các popup Course --}}
        @include('popup.add-course-form')
        @include('popup.edit-course-form')
        @include('popup.delete-course-form')

        {{-- Include các popup Student practise video record --}}
        @include('popup.add-student-practise-video-record-form')
        @include('popup.edit-student-practise-video-record-form')
        @include('popup.delete-student-practise-video-record-form')
        {{-- Include các popup Enrolment--}}
        @include('popup.add-enrolment-form')
        @include('popup.edit-enrolment-form')
        @include('popup.delete-enrolment-form')

        {{-- Include các popup word practise video--}}
        @include('popup.add-word-practise-video-form')
        @include('popup.edit-word-practise-video-form')
        @include('popup.delete-word-practise-video-form')

        {{-- Include các popup Word --}}
        @include('popup.add-word-form')
        @include('popup.edit-word-form')
        @include('popup.delete-word-form')
    </body>
</html>
