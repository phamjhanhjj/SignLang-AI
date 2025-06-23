<!DOCTYPE html>
<html>
<head>
    <title>Thêm Student</title>
</head>
<body>
<div id="add-student-form" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3); z-index:1000;">
    <div style="background:#fff; margin:100px auto; padding:20px; width:400px; border-radius:8px; position:relative;">
        <button onclick="document.getElementById('student-form').style.display='none'" style="position:absolute; top:10px; right:10px;">Đóng</button>
        <h2>Thêm Student</h2>
        <form id="create-student-form">
            <label>Student ID:</label>
            <input type="text" name="student_id" required><br><br>
            <label>Email:</label>
            <input type="email" name="email_address" pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$" required><br><br>
            <label>Password:</label>
            <input type="password" name="password" required><br><br>
            <label>Username:</label>
            <input type="text" name="username" required><br><br>
            <label>Age:</label>
            <input type="number" name="age" required><br><br>
            <label>Date of Birth:</label>
            <input type="date" name="date_of_birth" required><br><br>
            <label>Gender:</label>
            <select name="gender" required>
                <option value="">Chọn giới tính</option>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select><br><br>
            <button type="submit">Lưu</button>
        </form>
        <div id="student-form-message" style="color:green; margin-top:10px;"></div>
    </div>
</div>
</body>
