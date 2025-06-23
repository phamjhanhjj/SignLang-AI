<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <style>
        </style>
    </head>

    <body>
        <h1>Dashboard</h1>
        <p>Welcome to your dashboard!</p>
        <p>Here you can manage your account settings, view your activity, and more.</p>
        <div id = "all-tables" class = "box-container"></div>
        <div id  = "data-table" class = "data-table"></div>

        <script>
            // Lấy danh sách tất cả các bảng trong database và hiển thị thành các box
            function loadAllTables() {
                fetch('/dashboard/tables')
                    .then(res => res.json())
                    .then(tables => {
                        let html = '';
                        tables.forEach(table => {
                            html += `<div class="box" onclick="showData('${table}')">${table}</div>`;
                        });
                        document.getElementById('all-tables').innerHTML = html;
                    });
            }

            // Hiển thị dữ liệu cho từng bảng khi người dùng nhấn vào box
            function showData(table) {
                // Hiển thị nút thêm dữ liệu bên trên bảng dữ liệu
                let crudHtml = `
                    <div id = "crud-buttons">
                        <button onclick = "addData('${table}')">Thêm dữ liệu</button>
                    </div>
                `;
                document.getElementById('data-table').innerHTML = crudHtml;

                //Hiển thị dữ liệu của bảng
                fetch(`/dashboard/data/${table}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('data-table').innerHTML = crudHtml + html;
                    })
            }

            // Hàm thêm dữ liệu vào bảng
            function addData(table) {
                switch(table) {
                    case 'student':
                        showCreateStudentForm();
                        break;
                    default:
                        alert('Chức năng thêm dữ liệu chưa được hỗ trợ cho bảng này.');
                        break;
                }
            }

            // Hiển thị form thêm Student
            function showCreateStudentForm() {
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
                                document.getElementById('student-form-message').innerText = 'Thêm Student thành công|';
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
        </script>

        @include('popup.add-student-form')
    </body>
</html>
