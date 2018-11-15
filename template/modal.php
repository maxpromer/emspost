
<?Php if (!$login): ?>
<form id="user_login_form" method="post" class="form-horizontal">
  <div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">เข้าสู่ระบบ</h4>
        </div>
        <div class="modal-body">
          <fieldset>
            <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">อีเมล์</label>
              <div class="col-lg-10">
                <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com - ไม่เกิน 100 ตัวอักษร" maxlength="100" required>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPass" class="col-lg-2 control-label">รหัสผ่าน</label>
              <div class="col-lg-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="My password - ยาวไม่ต่ำกว่า 6 ตัวอักษร" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-2 control-label">&nbsp;</label>
              <div class="col-lg-10">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="rememberme" name="rememberme" value="1"> จดจำ
                  </label>
                </div>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" data-loading-text="<span class='glyphicon glyphicon-refresh rotate-infinite'></span> รอซักครู่...">เข้าสู่ระบบ</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
        </div>
      </div>
    </div>
  </div>
</form>

<form id="user_repass_form" method="post" class="form-horizontal">
  <div class="modal fade" id="RepassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">ลืมรหัสผ่าน</h4>
        </div>
        <div class="modal-body">
          <div class="alert alert-info">รหัสผ่านใหม่จะถูกส่งเข้าอีเมล์ของคุณ</div>
          <fieldset>
            <div class="form-group">
              <label for="inputEmail" class="col-lg-2 control-label">อีเมล์</label>
              <div class="col-lg-10">
                <input type="email" class="form-control" id="inputEmail" placeholder="example@domain.com" maxlength="100" required>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" data-loading-text="<span class='glyphicon glyphicon-refresh rotate-infinite'></span> รอซักครู่...">ส่งรหัสผ่านใหม่</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
        </div>
      </div>
    </div>
  </div>
</form>

<form id="user_register_form" method="post" class="form-horizontal">
  <div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">สมัครสมาชิก</h4>
        </div>
        <div class="modal-body">
          <fieldset>
            <div class="form-group">
              <label for="name" class="col-lg-2 control-label">ชื่อ</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="name" name="name" placeholder="ตัวอย่าง: กิ้บ 20 บาท" maxlength="100" required>
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-lg-2 control-label">อีเมล์</label>
              <div class="col-lg-10">
                <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com" maxlength="100" required>
              </div>
            </div>
            <div class="form-group">
              <label for="tel" class="col-lg-2 control-label">เบอร์โทร</label>
              <div class="col-lg-10">
                <input type="tel" class="form-control" id="tel" name="tel" placeholder="095-5555555" maxlength="11" required>
              </div>
            </div>
            <div class="form-group">
              <label for="password" class="col-lg-2 control-label">รหัสผ่าน</label>
              <div class="col-lg-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="My password" required>
              </div>
            </div>
            <div class="form-group">
              <label for="re-password" class="col-lg-2 control-label">ยืนยันรหัสผ่าน</label>
              <div class="col-lg-10">
                <input type="password" class="form-control" id="re-password" name="re-password" placeholder="My password" required>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" data-loading-text="<span class='glyphicon glyphicon-refresh rotate-infinite'></span> รอซักครู่...">สมัครสมาชิก</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
        </div>
      </div>
    </div>
  </div>
</form>
<?Php endif ?>
