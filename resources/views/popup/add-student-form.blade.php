<style>
    #add-student-form {
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
    .student-form-modal h2 {
        margin-top: 0;
        margin-bottom: 18px;
        font-size: 1.4rem;
        text-align: center;
        color: #333;
    }
    .student-form-modal label {
        display: block;
        margin-bottom: 4px;
        font-weight: 500;
        color: #444;
    }
    .student-form-modal input,
    .student-form-modal select {
        width: 100%;
        padding: 8px 10px;
        margin-bottom: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        background: #fafbfc;
        transition: border 0.2s;
    }
    .student-form-modal input:focus,
    .student-form-modal select:focus {
        border: 1.5px solid #007bff;
        outline: none;
    }
    .student-form-modal button[type="submit"] {
        width: 100%;
        background: #007bff;
        color: #fff;
        border: none;
        padding: 10px 0;
        border-radius: 5px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .student-form-modal button[type="submit"]:hover {
        background: #0056b3;
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
    #student-form-message {
        color: green;
        margin-top: 10px;
        text-align: center;
        font-weight: 500;
    }
</style>

<div id="add-student-form">
    <div class="student-form-modal">
        <button class="close-btn" onclick="document.getElementById('add-student-form').style.display='none'">&times;</button>
        <h2>Thêm Student</h2>
        <form id="create-student-form">
            <label>Student ID:</label>
            <input type="text" name="student_id" required>
            <label>Username:</label>
            <input type="text" name="username">
            <label>Age:</label>
            <input type="number" name="age" min="1">
            <label>Date of Birth:</label>
            <input type="date" name="date_of_birth" >
            <label>Gender:</label>
            <select name="gender" >
                <option value="">Chọn giới tính</option>
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>
            <button type="submit">Lưu</button>
        </form>
        <div id="student-form-message"></div>
    </div>
</div>
