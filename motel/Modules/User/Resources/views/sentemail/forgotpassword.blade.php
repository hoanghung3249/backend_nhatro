<!DOCTYPE html>
<html>
<head>
	<title>email</title>
</head>
<body>

<table cellspacing="0" cellpadding=" 0 20px" style=" font-family: 'helvetica-neue', helvetica, arial, sans-serif">
	<tr height="50px">
		<td></td>
		<td colspan="2" style="padding-left: 15px">Hi, {{ $user->first_name }}</td>
		<td style="text-align: right "><img width="50%" src=""></td>
	</tr>
	<tr>
		<td height: 30px></td>
		<td style="height: 30px;border-top:1px solid rgba(16, 16, 16, 0.25); border-left:1px solid rgba(16, 16, 16, 0.25);"></td><td style="height: 30px;border-top:1px solid rgba(16, 16, 16, 0.25)"></td>
		<td style="height: 30px;border-top:1px solid rgba(16, 16, 16, 0.25); border-right:1px solid rgba(16, 16, 16, 0.25); "></td>
		<td style="height: 30px"></td>
	</tr>

	<tr>
		<td style="background-color: #3498db; padding-left:30px;" ></td>
		<td colspan="3" style="border-left:1px solid rgba(16, 16, 16, 0.25);    border-right: 1px solid rgba(16, 16, 16, 0.25);">
			<div colspan="1" style="margin-left: 22px; margin-right: 22px">
				<h3>Reset Password</h3>
				
				<p style="font-size: 14px;line-height: 1.71;letter-spacing: -0.4px;color: rgba(0, 0, 0, 0.54);margin-top: 0; padding-top: 40px;">To change your password, click<a href="{{env('URL_MAIL')}}/reset-password/{{$user->id}}/{{$token}}"> here</a> </p>
				<p style="font-size: 12px;line-height: 1.33;letter-spacing: -0.4px;color: rgba(0, 0, 0, 0.54); padding-bottom: 15px; padding-top: 40px;">{{date('d M Y h:i A', strtotime(\Carbon\Carbon::now()->timezone('Asia/Ho_Chi_Minh')) )}}</p>
				<p style="margin-bottom: 0; margin-top: 0">&nbsp;</p>
			</div>
		</td>

		<td style=" border-right:1px solid rgba(16, 16, 16, 0.25);"></td>
		<td style="background-color: #3498db;  padding-left:30px;" ></td>
	</tr>

	
	<tr>
		<td style="height: 10px;background-color: #3498db"></td>
		<td style="height: 10px; border-left:1px solid rgba(16, 16, 16, 0.25);"></td>
		<td></td>
		<td style="border-right:1px solid rgba(16, 16, 16, 0.25);" ></td>

		<td style="height: 10px;border-right:1px solid rgba(16, 16, 16, 0.25) "></td>
		<td style="height: 10px;background-color: #3498db;"></td>
	</tr>
	<tr>
		
		<td style="background-color: #3498db; text-align: center; padding: 20px 0" colspan="6">
		 	<p style="color:#fff">Thank you for choosing Services Solution.</p>
			<a href="{{ env('BASE_PATH') }}" style="color: #fff; text-decoration: underline; ">Go to Site</a>
			<p style="font-size: 12px;line-height: 1.33;letter-spacing: -0.4px;text-align: center;color: rgba(255, 255, 255, 0.7); margin-top: 20px; margin-bottom: 0">This is an automated notification. Please do not reply to this email.</p>
		</td>
	</tr>

	<tr>
		<td style="background-color: #073a5c; color: rgba(255, 255, 255, 0.7); padding: 20px 0 20px 50px; " colspan="6">Need help?  <a href="{{ env('BASE_CONTACT') }}"" style="color: #fff"> Contact Us </a></td>
	</tr>
</table>
</body>
</html>