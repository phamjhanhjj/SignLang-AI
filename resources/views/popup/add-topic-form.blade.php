<style>
    #add-topic-form {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.3);
        z-index: 1000;
    }
    .topic-form-modal {
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
    .topic-form-modal h2 {
        margin-top: 0;
        margin-bottom: 18px;
        font-size: 1.4rem;
        text-align: center;
        color: #333;
    }
    .topic-form-modal label {
        display: block;
        margin-bottom: 4px;
        font-weight: 500;
        color: #444;
    }
    .topic-form-modal input,
    .topic-form-modal select {
        width: 100%;
        padding: 8px 10px;
        margin-bottom: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        background: #fafbfc;
        transition: border 0.2s;
    }
    .topic-form-modal input:focus,
    .topic-form-modal select:focus {
        border: 1.5px solid #007bff;
        outline: none;
    }
    .topic-form-modal button[type="submit"] {
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
    .topic-form-modal button[type="submit"]:hover {
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
    #topic-form-message {
        color: green;
        margin-top: 10px;
        text-align: center;
        font-weight: 500;
    }
</style>

<div id="add-topic-form">
    <div class="topic-form-modal">
        <button class="close-btn" onclick="document.getElementById('add-topic-form').style.display='none'">&times;</button>
        <h2>Thêm Topic</h2>
        <form id="create-topic-form">
            <label>Course:</label>
            <select name="course_id" id="topic-course-select" required>
                <option value="">-- Chọn khóa học --</option>
                <!-- Option sẽ được render động bằng JS -->
            </select>
            <label>Tên chủ đề:</label>
            <input type="text" name="name" required>
            <label>Level:</label>
            <input type="number" name="level" required min="1" value="1">
            <label>Số từ:</label>
            <input type="number" name="number_of_word" required min="0" value="0">
            <button type="submit">Lưu</button>
        </form>
        <div id="topic-form-message"></div>
    </div>
</div>
