<!-- filepath: d:\Đồ án liên ngành\SignLang-AI\resources\views\popup\delete-topic-form.blade.php -->
<style>
    #delete-word-practise-video-form {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        background: rgba(0,0,0,0.3);
        z-index: 2000;
    }
    .delete-confirm-modal {
        background: #fff;
        margin: 120px auto;
        padding: 24px 32px 18px 32px;
        width: 340px;
        border-radius: 10px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        position: relative;
        text-align: center;
        animation: fadeIn 0.2s;
    }
    .delete-confirm-modal button {
        margin: 0 10px;
        padding: 7px 18px;
        border-radius: 5px;
        border: none;
        font-size: 1rem;
        cursor: pointer;
        font-weight: 500;
        transition: background 0.2s;
    }
    .delete-confirm-modal .btn-cancel {
        background: #eee;
        color: #333;
    }
    .delete-confirm-modal .btn-cancel:hover {
        background: #ccc;
    }
    .delete-confirm-modal .btn-delete {
        background: #e74c3c;
        color: #fff;
    }
    .delete-confirm-modal .btn-delete:hover {
        background: #c0392b;
    }
</style>
<div id="delete-word-practise-video-form">
    <div class="delete-confirm-modal">
        <div style="font-size:1.1rem; margin-bottom:18px;">
            Bạn có chắc chắn muốn xóa dữ liệu này?
        </div>
        <button class="btn-cancel" onclick="closeDeleteWordPractiseVideoPopup()">Hủy</button>
        <button class="btn-delete" onclick="confirmDeleteWordPractiseVideo()">Xóa</button>
        <div id="delete-word-practise-video-form-message" style="margin-top:10px;color:red;"></div>
    </div>
</div>
