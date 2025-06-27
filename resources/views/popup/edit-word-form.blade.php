<!-- filepath: d:\Đồ án liên ngành\SignLang-AI\resources\views\popup\edit-word-form.blade.php -->
<style>
    #edit-word-form {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.3);
        z-index: 1000;
    }
    .word-form-modal {
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
    #edit-word-form-message {
        color: green;
        margin-top: 10px;
        text-align: center;
        font-weight: 500;
    }
    .word-form-modal label {
        display: block;
        margin-top: 10px;
        font-weight: 500;
    }
    .word-form-modal input,
    .word-form-modal select {
        width: 100%;
        padding: 7px 10px;
        margin-top: 4px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        margin-bottom: 2px;
    }
    .word-form-modal button[type="submit"] {
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
    .word-form-modal button[type="submit"]:hover {
        background: #1976d2;
    }
</style>

<div id="edit-word-form">
    <div class="word-form-modal">
        <button class="close-btn" onclick="document.getElementById('edit-word-form').style.display='none'">&times;</button>
        <h2>Sửa Word</h2>
        <form id="update-word-form">
            <label>Word ID:</label>
            <input type="text" name="word_id" readonly>
            <label>Topic:</label>
            <select name="topic_id" id="edit-word-topic-select" required>
                <option value="">-- Chọn chủ đề --</option>
                <!-- Option sẽ được render động bằng JS -->
            </select>
            <label>Từ vựng:</label>
            <input type="text" name="word" required>
            <label>Ý nghĩa:</label>
            <input type="text" name="meaning" required>
            <label>Điểm:</label>
            <input type="number" name="score" min="0" value="0" required>
            <button type="submit">Cập nhật</button>
        </form>
        <div id="edit-word-form-message"></div>
    </div>
</div>
