# SignLang-AI Backend

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

## Giới thiệu

**SignLang-AI** là hệ thống backend cho ứng dụng học ngôn ngữ ký hiệu Việt Nam. Dự án sử dụng Laravel framework để xây dựng RESTful API, hỗ trợ học sinh học và thực hành ngôn ngữ ký hiệu qua các video và bài tập tương tác.

## Tính năng chính

### 🎯 Quản lý học sinh
- Tạo và quản lý tài khoản học sinh
- Theo dõi tiến độ học tập
- Cập nhật thông tin cá nhân

### 📚 Hệ thống học tập
- **3 chủ đề học tập:**
  - Topic 1: Alphabet (29 chữ cái)
  - Topic 2: Numbers (22 số)
  - Topic 3: Diacritics (5 dấu thanh)
- Video học tập cho từng từ
- Theo dõi trạng thái học tập và thành thạo

### 🎮 Bài tập thực hành
- **Practise 1:** Chọn đáp án đúng từ video
- **Practise 2:** Ghép từ từ các thành phần
- Theo dõi số lần replay và điểm số

### 📊 Theo dõi tiến độ
- Phần trăm hoàn thành từng chủ đề
- Số từ đã học và đã thành thạo
- Hệ thống level và unlock chủ đề mới

## Cấu trúc Database

### Bảng chính
- `student` - Thông tin học sinh
- `course` - Khóa học
- `topic` - Chủ đề học tập
- `word` - Từ vựng
- `learn_videos` - Video học tập
- `student_word_record` - Bản ghi học từ của học sinh
- `student_topic_record` - Tiến độ học chủ đề
- `student_progress` - Tổng quan tiến độ học sinh

## Cài đặt

### Yêu cầu hệ thống
- PHP >= 8.1
- Composer
- MySQL >= 8.0
- Laravel 11.x

### Hướng dẫn cài đặt

1. **Clone repository**
```bash
git clone https://github.com/yourusername/SignLang-AI.git
cd SignLang-AI
```

2. **Cài đặt dependencies**
```bash
composer install
```

3. **Cấu hình môi trường**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Cấu hình database trong file `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=signlang_ai
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Chạy migration và seeder**
```bash
php artisan migrate:fresh --seed
```

6. **Khởi chạy server**
```bash
php artisan serve
```

## API Endpoints

### Student Management
```http
POST /api/students                     # Tạo học sinh mới
PUT /api/students/{id}                 # Cập nhật thông tin học sinh
```

### Topic & Learning
```http
GET /api/topics/{student_id}           # Danh sách chủ đề và tiến độ
GET /api/learn                         # Lấy nội dung học tập
```

### Word Records
```http
GET /api/word-records/{student_id}     # Bản ghi từ của học sinh
POST /api/word-records                 # Tạo bản ghi học từ mới
PUT /api/word-records/{id}             # Cập nhật bản ghi học từ
```

### Progress Tracking
```http
GET /api/progress/{student_id}         # Tiến độ tổng quan
POST /api/progress                     # Cập nhật tiến độ
```

## Cấu trúc dữ liệu

### Response format
```json
{
  "status": "success",
  "data": {
    // Dữ liệu response
  },
  "message": "Thông báo"
}
```

### Error format
```json
{
  "success": false,
  "error_code": 400,
  "message": "Mô tả lỗi"
}
```

## Seeders

Dự án bao gồm các seeder để tạo dữ liệu mẫu:

```bash
php artisan db:seed --class=CourseSeeder
php artisan db:seed --class=TopicSeeder
php artisan db:seed --class=WordSeeder
php artisan db:seed --class=LearnVideoSeeder
```

## Logic nghiệp vụ

### Auto-create Topic Records
- Khi học sinh được tạo → Tự động tạo record cho Topic 1
- Khi học từ thuộc topic mới → Tự động tạo record cho topic đó

### Progress Calculation
- `current_word`: Số từ đã thành thạo trong topic
- `is_completed`: Topic hoàn thành khi học xong tất cả từ
- `percentage`: Phần trăm = (current_word / total_words) × 100

### Level System
- Đạt ≥70% topic hiện tại → Unlock topic level tiếp theo
- Tự động tạo record cho topic mới khi unlock

## Cấu trúc thư mục

```
app/
├── Http/
│   └── Controllers/
│       ├── Api/                    # API Controllers
│       │   ├── StudentApiController.php
│       │   ├── TopicListApiController.php
│       │   ├── LearnApiController.php
│       │   └── StudentWordRecordApiController.php
│       └── [Other Controllers]
├── Models/                         # Eloquent Models
│   ├── Student.php
│   ├── Topic.php
│   ├── Word.php
│   ├── StudentWordRecord.php
│   └── StudentTopicRecord.php
database/
├── migrations/                     # Database migrations
├── seeders/                        # Database seeders
└── factories/                      # Model factories
```

## Phát triển

### Thêm chủ đề mới
1. Thêm topic vào `TopicSeeder`
2. Thêm từ vựng vào `WordSeeder`
3. Thêm video vào `LearnVideoSeeder`
4. Cập nhật logic level trong controllers

### Testing
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

## Đóng góp

1. Fork repository
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

## Licence

Dự án này được phát hành under [MIT License](LICENSE).

## Liên hệ

- **Phát triển:** [PHẠM THỊ HẠNH]
- **Email:** [phanh12012004@gmai.com]
- **GitHub:** [https://github.com/phamjhanhjj/SignLang-AI]

---

> 🚀 **SignLang-AI** - Hệ thống học ngôn ngữ ký hiệu thông minh
