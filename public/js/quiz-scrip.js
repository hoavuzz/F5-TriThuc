    // const timeRange = document.getElementById('time-range');
    // const timeDisplay = document.getElementById('time-display');

    // timeRange.addEventListener('input', function () {
    //     timeDisplay.textContent = `${this.value} phút`;
    // });

    // const timeRange = document.getElementById('time-range');
    // const timeDisplay = document.getElementById('time-display');
    // const hiddenTime = document.getElementById('hidden-time');

    // timeRange.addEventListener('input', function () {
    //     timeDisplay.textContent = `${this.value} phút`;
    //     hiddenTime.value = this.value; // cập nhật vào input ẩn
    // });

    document.getElementById('quizForm').addEventListener('submit', function (e) {
        const meth = document.getElementById('meth-value').value;

        // Gán giá trị page tương ứng với loại câu hỏi
        let targetPage = '';
        if (meth == 1) {
            targetPage = 'quiz-upload-select';
        } else if (meth == 2) {
            targetPage = 'quiz-upload-passage';
        } else {
            alert('Vui lòng chọn loại câu hỏi hợp lệ!');
            e.preventDefault();
            return;
        }

        // Gán action cho form: vẫn là file hiện tại, nhưng thêm ?page=
        this.action = '?page=' + targetPage;

        // Cập nhật thời gian từ slider
        const time = document.getElementById('time-range').value;
        document.getElementById('hidden-time').value = time;
    });

    // Hiển thị thời gian khi thay đổi
    document.getElementById('time-range').addEventListener('input', function () {
        document.getElementById('time-display').textContent = this.value + ' phút';
    });

    document.getElementById('quizForm').addEventListener('submit', function (e) {
        // Lấy meth hiện tại
        const meth = document.querySelector('input[name="meth"]').value;

        // Cập nhật hidden input "page"
        const pageInput = document.querySelector('input[name="page"]');
        if (meth == 2) {
            pageInput.value = 'quiz-upload-passage';
        } else {
            pageInput.value = 'quiz-upload-select'; // fallback cho meth == 1 hoặc bất kỳ
        }

        // Cập nhật thời gian từ slider
        const time = document.getElementById('time-range').value;
        document.getElementById('hidden-time').value = time;
    });

    // Cập nhật hiển thị số phút khi kéo thanh range
    document.getElementById('time-range').addEventListener('input', function () {
        document.getElementById('time-display').textContent = this.value + ' phút';
    });
