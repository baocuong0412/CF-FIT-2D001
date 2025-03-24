<div id="header">
    <div class="header">
        <div class="header-title">
            <p>Tìm phòng nhanh - Quản trị hệ thống</p>
        </div>
        <div class="text-end me-5">
            <a href="#" class="btn btn-danger register">Tạo TK Admin</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $(".register").on("click", function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>

            Swal.fire({
                title: "Đăng ký tài khoản",
                width: "500px",
                padding: "20px",
                html: `
                <div style="display: flex; flex-direction: column; gap: 15px; text-align: left;">
                    <input type="text" id="name" class="swal2-input" placeholder="Tên đăng nhập" 
                           style="width: 90%; font-size: 20px; padding: 15px; border-radius: 10px; border: 2px solid #ccc; margin: 10px auto;">
                    <input type="email" id="email" class="swal2-input" placeholder="Email" 
                           style="width: 90%; font-size: 20px; padding: 15px; border-radius: 10px; border: 2px solid #ccc; margin: 10px auto;">
                    <input type="password" id="password" class="swal2-input" placeholder="Mật khẩu" 
                           style="width: 90%; font-size: 20px; padding: 15px; border-radius: 10px; border: 2px solid #ccc; margin: 10px auto;">
                </div>
            `,
                showCancelButton: true,
                confirmButtonText: "Đăng ký",
                cancelButtonText: "Hủy",
                customClass: {
                    confirmButton: "custom-confirm-btn",
                    cancelButton: "custom-cancel-btn"
                },
                preConfirm: () => {
                    const name = $("#name").val();
                    const email = $("#email").val();
                    const password = $("#password").val();

                    if (!name || !email || !password) {
                        Swal.showValidationMessage("Vui lòng nhập đầy đủ thông tin!");
                        return false;
                    }

                    return {
                        name,
                        email,
                        password
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Đang xử lý...",
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    $.ajax({
                        url: "/admin/register/store", // Thay vì Blade, dùng đường dẫn trực tiếp
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                        },
                        data: {
                            name: result.value.name,
                            email: result.value.email,
                            password: result.value.password
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire("Thành công!",
                                    "Bạn đã đăng ký thành công!", "success");
                            } else {
                                let errorMsg = data.message || "Đăng ký thất bại";
                                if (data.errors) {
                                    errorMsg = Object.values(data.errors).flat()
                                        .join("<br>");
                                }
                                Swal.fire("Lỗi!", errorMsg, "error");
                            }
                        },
                        error: function(xhr) {
                            let errorMsg = "Có lỗi xảy ra, vui lòng thử lại!";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire("Lỗi!", errorMsg, "error");
                        }
                    });
                }
            });
        });
    });
</script>

<style>
    .custom-confirm-btn {
        font-size: 18px !important;
        padding: 12px 25px !important;
        border-radius: 8px !important;
        background-color: #3085d6 !important;
    }

    .custom-cancel-btn {
        font-size: 18px !important;
        padding: 12px 25px !important;
        border-radius: 8px !important;
        background-color: #d33 !important;
    }
</style>
