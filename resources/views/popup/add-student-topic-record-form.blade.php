<style>
    #add-student-topic-record-form {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.3);
        z-index: 1000;
    }
    .student-topic-record-form-modal {
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
    .student-topic-record-form-modal h2 {
        margin-top: 0;
        margin-bottom: 18px;
        font-size: 1.4rem;
        text-align: center;
        color: #333;
    }
    .student-topic-record-form-modal label {
        display: block;
        margin-bottom: 4px;
        font-weight: 500;
        color: #444;
    }
    .student-topic-record-form-modal input,
    .student-topic-record-form-modal select {
        width: 100%;
        padding: 8px 10px;
        margin-bottom: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        background: #fafbfc;
        transition: border 0.2s;
    }
    .student-topic-record-form-modal input:focus,
    .student-topic-record-form-modal select:focus {
        border: 1.5px solid #007bff;
        outline: none;
    }
    .student-topic-record-form-modal button[type="submit"] {
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
    .student-topic-record-form-modal button[type="submit"]:hover {
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
    #student-topic-record-form-message {
        color: green;
        margin-top: 10px;
        text-align: center;
        font-weight: 500;
    }
</style>

<div id="add-student-topic-record-form">
    <div class="student-topic-record-form-modal">
        <button class="close-btn" onclick="document.getElementById('add-student-topic-record-form').style.display='none'">&times;</button>
        <h2>Thêm Student Topic Record</h2>
        <form id="create-student-topic-record-form">
            @csrf
            <label>Student:</label>
            <select name="student_id" id="student-topic-record-student-select" required>
                <option value="">-- Chọn Student --</option>
                <!-- Option sẽ được render động bằng JS -->
            </select>

            <label>Topic:</label>
            <select name="topic_id" id="student-topic-record-topic-select" required>
                <option value="">-- Chọn Topic --</option>
                <!-- Option sẽ được render động bằng JS -->
            </select>

            <label>Is Completed:</label>
            <select name="is_completed" id="is-completed-select" required>
                <option value="">-- Chọn trạng thái --</option>
                <option value="0">False</option>
                <option value="1">True</option>
            </select>

            <!-- Current Word sẽ tự động được đặt là 0 khi tạo mới -->
            <input type="hidden" name="current_word" value="0">

            <button type="submit">Lưu</button>
        </form>
        <div id="student-topic-record-form-message"></div>
    </div>
</div>
