<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <style>
            .box {
                display: inline-block;
                margin: 10px;
                padding: 10px 20px;
                border: 1px solid #ccc;
                border-radius: 6px;
                background: #f5f5f5;
                cursor: pointer;
                transition: background 0.2s;
            }
            .box:hover {
                background: #e0e0e0;
            }
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
                    case 'course':
                        showCreateCourseForm();
                        break;
                    case 'topic':
                        showCreateTopicForm();
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

            function editData(table, id) {
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
                        form.email_address.value = data.email_address;
                        form.password.value = '';
                        form.username.value = data.username;
                        form.age.value = data.age;
                        form.date_of_birth.value = data.date_of_birth;
                        form.gender.value = data.gender;
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

            //Xóa dữ liệu
            let deleteTable = '';
            let deleteId = '';
            function deleteData(table, id) {
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

        </script>

        {{-- Include các popup Student --}}
        @include('popup.add-student-form')
        @include('popup.edit-student-form')
        @include('popup.delete-student-form')

        {{-- Include các popup Student Progress --}}
        @include('popup.edit-student-progress-form')

        {{-- Include các popup Course --}}
        @include('popup.add-course-form')
        @include('popup.edit-course-form')
        @include('popup.delete-course-form')

        {{-- Include các popup Topic --}}
        @include('popup.add-topic-form')
        @include('popup.edit-topic-form')
        @include('popup.delete-topic-form')

    </body>
</html>
