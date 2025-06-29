<!-- filepath: d:\Đồ án liên ngành\SignLang-AI\resources\views\popup\edit-topic-form.blade.php -->
<style>
    #edit-enrolment-form {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.3);
        z-index: 1000;
    }
    .enrolment-form-modal {
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
    #edit-enrolment-form-message {
        color: green;
        margin-top: 10px;
        text-align: center;
        font-weight: 500;
    }
    .enrolment-form-modal label {
        display: block;
        margin-top: 10px;
        font-weight: 500;
    }
    .enrolment-form-modal input,
    .enrolment-form-modal select {
        width: 100%;
        padding: 7px 10px;
        margin-top: 4px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        margin-bottom: 2px;
    }
    .enrolment-form-modal button[type="submit"] {
        width: 100%;
        margin-top: 18px;
        padding: 8px 0;
        background: #2196f3;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }
    .enrolment-form-modal button[type="submit"]:hover {
        background: #1976d2;
    }
</style>

<div id="edit-enrolment-form">
    <div class="enrolment-form-modal">
        <button class="close-btn" onclick="document.getElementById('edit-enrolment-form').style.display='none'">&times;</button>
        <h2>Sửa thông tin Enrolment</h2>
        <form id="update-enrolment-form">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="enrolment_id" id="edit-enrolment-id">

            <label>Student:</label>
            <select name="student_id" id="edit-enrolment-student-select" required>
                <option value="">-- Chọn Student --</option>
                <!-- Option sẽ được render động bằng JS -->
            </select>

            <label>Course:</label>
            <select name="course_id" id="edit-enrolment-course-select" required>
                <option value="">-- Chọn khóa học --</option>
                <!-- Option sẽ được render động bằng JS -->
            </select>

            <label>Enrolment Datetime:</label>
            <input type="datetime-local" name="enrolment_datetime" id="edit-enrolment-datetime" required>

            <label>Is Completed:</label>
            <select name="is_completed" id="edit-enrolment-is-completed-select" required>
                <option value="">-- Chọn trạng thái --</option>
                <option value="0">False</option>
                <option value="1">True</option>
            </select>

            <button type="submit">Cập nhật</button>
        </form>
        <div id="edit-enrolment-form-message"></div>
    </div>
</div>
