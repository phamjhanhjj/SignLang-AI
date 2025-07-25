<!-- filepath: d:\Đồ án liên ngành\SignLang-AI\resources\views\popup\edit-topic-form.blade.php -->
<style>
    #edit-student-word-record-form {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.3);
        z-index: 1000;
    }
    .student-word-record-form-modal {
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
    #edit-student-word-record-form-message {
        color: green;
        margin-top: 10px;
        text-align: center;
        font-weight: 500;
    }
    .student-word-record-form-modal label {
        display: block;
        margin-top: 10px;
        font-weight: 500;
    }
    .student-word-record-form-modal input,
    .student-word-record-form-modal select {
        width: 100%;
        padding: 7px 10px;
        margin-top: 4px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        margin-bottom: 2px;
    }
    .student-word-record-form-modal button[type="submit"] {
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
    .student-word-record-form-modal button[type="submit"]:hover {
        background: #1976d2;
    }
</style>

<div id="edit-student-word-record-form">
    <div class="student-word-record-form-modal">
        <button class="close-btn" onclick="document.getElementById('edit-student-word-record-form').style.display='none'">&times;</button>
        <h2>Sửa thông tin Student Word Record</h2>
        <form id="update-student-word-record-form">
            <label>Student Practise Video Record ID:</label>
            <input type="text" name="student_word_record_id" readonly>
            <label>Student:</label>
            <select name="student_id" id="edit-student-word-record-student-select" required>
                <option value="">-- Chọn Student --</option>
                <!-- Option sẽ được render động bằng JS -->
            </select>

            <label>Word Video:</label>
            <select name="word_id" id="edit-student-word-record-word-select" required>
                <option value="">-- Chọn Word --</option>
                <!-- Option sẽ được render động bằng JS -->
            </select>

            <label>Is Learned:</label>
            <select name="is_learned" id="edit-is-learned-select" required>
                <option value="">-- Chọn trạng thái --</option>
                <option value="0">False</option>
                <option value="1">True</option>
            </select>

            <label>Replay Time:</label>
            <input type="number" name="replay_time" id="edit-word-replay-time-input" required placeholder="Nhập số lần xem lại" min="0">

            <label>Is Mastered:</label>
            <select name="is_mastered" id="edit-is-mastered-select" required>
                <option value="">-- Chọn trạng thái --</option>
                <option value="0">False</option>
                <option value="1">True</option>
            </select>
            <button type="submit">Cập nhật</button>
        </form>
        <div id="edit-student-word-record-form-message"></div>
    </div>
</div>
