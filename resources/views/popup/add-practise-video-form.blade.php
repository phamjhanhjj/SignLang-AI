<style>
    #add-practise-video-form {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.5);
        z-index: 1000;
    }
    .practise-video-form-modal {
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
    .practise-video-form-modal h2 {
        margin-top: 0;
        margin-bottom: 18px;
        font-size: 1.4rem;
        text-align: center;
        color: #333;
    }
    .practise-video-form-modal label {
        display: block;
        margin-bottom: 4px;
        font-weight: 500;
        color: #444;
    }
    .practise-video-form-modal input,
    .practise-video-form-modal select,
    .practise-video-form-modal textarea {
        width: 100%;
        padding: 8px 10px;
        margin-bottom: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        background: #fafbfc;
        transition: border 0.2s;
        box-sizing: border-box;
    }
    .practise-video-form-modal input:focus,
    .practise-video-form-modal select:focus,
    .practise-video-form-modal textarea:focus {
        border: 1.5px solid #007bff;
        outline: none;
    }
    .practise-video-form-modal textarea {
        height: 80px;
        resize: vertical;
    }
    .practise-video-form-modal button[type="submit"] {
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
    .practise-video-form-modal button[type="submit"]:hover {
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
    #practise-video-form-message {
        color: green;
        margin-top: 10px;
        text-align: center;
        font-weight: 500;
    }
</style>

<div id="add-practise-video-form">
    <div class="practise-video-form-modal">
        <button class="close-btn" onclick="document.getElementById('add-practise-video-form').style.display='none'">&times;</button>
        <h2>Thêm Practise Video</h2>
        <form id="create-practise-video-form">
            <label>Khóa học:</label>
            <select name="course_id" id="practise-video-course-select" required>
                <option value="">-- Chọn khóa học --</option>
                <!-- Option sẽ được render động bằng JS -->
            </select>

            <label>Link Video:</label>
            <input type="url" name="video_link" required placeholder="https://example.com/video.mp4">

            <label>Phụ đề (JSON):</label>
            <textarea name="subtitle" required placeholder='{"en": "English subtitle", "vi": "Phụ đề tiếng Việt"}'></textarea>

            <label>Điểm:</label>
            <input type="number" name="score" required min="0" value="0">

            <button type="submit">Lưu</button>
        </form>
        <div id="practise-video-form-message"></div>
    </div>
</div>
