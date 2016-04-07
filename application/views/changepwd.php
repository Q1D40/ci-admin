
<div class="pageContent">

	<form method="post" action="index.php?/user/changepwd/" class="pageForm required-validate" onsubmit="return dialogSearch(this);">
		<div class="pageFormContent" layoutH="58">
            <div class="unit" style="text-align: center;">
                <span style="font-size: 30px; color: red;"><?php echo $info['error'];?></span>
                <span style="font-size: 30px; color: green;"><?php echo $info['success'];?></span>
            </div>
			<div class="unit">
				<label>旧密码：</label>
				<input type="password" name="oldPassword" size="30" class="required" />
			</div>
			<div class="unit">
				<label>新密码：</label>
				<input type="password" id="cp_newPassword" name="newPassword" size="30" class="required alphanumeric"/>
			</div>
			<div class="unit">
				<label>重复输入新密码：</label>
				<input type="password" name="rnewPassword" size="30" equalTo="#cp_newPassword" class="required alphanumeric"/>
			</div>

		</div>
		<div class="formBar">
			<ul>
				<li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
				<li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
			</ul>
		</div>
	</form>

</div>
