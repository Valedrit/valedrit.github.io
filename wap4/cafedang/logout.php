{% use '_includes_forum' %}
{% set title = 'Đăng xuất | BlogBB' %}
{{block('head')}}
{% set logout=get_post('logout') %}
{% if request_method()|lower == "post" %}
{% if logout %}
{{ delete_cookie('token') }}
<script language="javascript" type="text/javascript"> 
window.location.href="/community"; 
</script> 
<META HTTP-EQUIV="Refresh" CONTENT="0;URL=/community">
{% endif %}
{% else %}
<div class="gmenu">
<p><font color="red">Bạn có muốn đăng xuất bây giờ không?</font></p>
<form method="post" action=""><p><input class="btn btn-primary" type="submit" name="logout" value="Đồng ý"/></p></form>
</div>
{% endif %}
{{block('end')}}