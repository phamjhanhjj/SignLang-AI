    <style>
        #edit-student-form {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.3);
            z-index: 1000;
        }
        .student-form-modal {
            background: #fff;
            margin: 80px auto;
            padding: 30px 32px 20px 32px;
            width: 400px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            position: relative;
            animation: fadeIn 0.3s;
        }
        @keyframes fadeIn {
            from {transform: translateY(-40px); opacity: 0;}
            to {transform: translateY(0); opacity: 1;}
        }
        .close-btn {
            position: absolute;
            top: 12px;
            right: 16px;
            background: transparent;
            border: none;
            font-size: 1.3rem;
            color: #888;
            cursor: pointer;
            transition: color 0.2s;
        }
        .close-btn:hover {
            color: #e74c3c;
        }
        #edit-student-form-message {
            color: green;
            margin-top: 10px;
            text-align: center;
            font-weight: 500;
        }
    </style>

    <div id="edit-student-form">
        <div class="student-form-modal">
            <button class="close-btn" onclick="document.getElementById('edit-student-form').style.display='none'">&times;</button>
            <h2>Sửa thông tin Student</h2>
            <form id="update-student-form">
                <label>Student ID:</label>
                <input type="text" name="student_id" readonly>
                <label>Username:</label>
                <input type="text" name="username" >
                <label>Age:</label>
                <input type="number" name="age"  min="1">
                <label>Date of Birth:</label>
                <input type="date" name="date_of_birth" >
                <label>Gender:</label>
                <select name="gender" >
                    <option value="">Chọn giới tính</option>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                    <option value="Khác">Khác</option>
                </select>
                <button type="submit">Cập nhật</button>
            </form>
            <div id="edit-student-form-message"></div>
        </div>
    </div>
