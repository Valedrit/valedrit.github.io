{% import '_functions' as func %}
{% import 'chat_module_bot' as bot %}
{% set signin=func.signin()|trim %}
{% if signin %}
{% set name = signin %}
{% else %}
{% set name = 'anonymous' %}
{% endif %}
{% set ubot = get_data('bot')[0].data|json_decode %}
{% set xc = ubot['xc'] %}
{% set id = func.get('guestbook')|split('@')[99]|trim %}
{% set msg = get_post('msg') %}
{% set now = "now"|date("U") %}
{% if msg != '' and msg != '\r\n' and msg!=null %}
{{set_cookie('msg_n',msg)}} 
{% if msg and get_cookie('msg_n')|trim|raw != get_cookie('msg_o')|trim|raw %}
{% set comment = {"name" :name,"time":now,"comment":msg} %}
{{func.add('chat_'~id,'name',name)}}
{{func.add('chat_'~id,'time',now)}}
{{func.add('chat_'~id,'comment',msg)}} 
{{set_cookie('msg_o',msg)}} 
{{func.up('guestbook',id,'up') }}
{{bot.xepchu(msg)}}
{{bot.botchat(msg)}}
{% endif %}
{% endif %}
{% set data= func.get('guestbook')|trim|split('@') %}
{% set total=data|length-2 %} 
 {% set page_max=total//10 %}
{% if total//10 != total/10 %}
{% set page_max=total//10+1 %}
{% endif %}
 {% set url=get_uri_segments() %}
{% set p=get_get('p')|default(1) %} 

{% if p matches '/[a-zA-z]|%/' or p<1 %}
{% set p=1 %}
{% endif %}
{% if p>page_max %}
{% set p=page_max %}
{% endif %}
{% set st=p*10-10 %}

{% if ubot['xc'].time >= "now"|date("U") %}
<div class="card" align="center"><div class="card-content">
{% if ubot['xc'].time=="now"|date("U") %}
Hết giờ !!!
{% else %}
Sắp xếp các chữ sau thành từ hoặc cụm từ hoàn chỉnh:<br/>{{ubot['xc'].quest}}
<br/>Còn: {{(ubot['xc'].time)-("now"|date("U"))}} giây nữa
{% endif %}
</div></div>
{% endif %}

{% for id in data|slice(0,total)|slice(st,10) %}
{% set entry = get_data('chat_'~id|trim)[0].data|json_decode %}
{% set jun = now-time %}
{% if jun > 1 %}
{% set agos = entry.time|date('H:i:s -
 d/m/y',"Asia/Ho_Chi_Minh") %}
{% else %}
{% set agos = 'vừa xong' %}
{% endif %}
{% if entry.name %}
{% set udata=get_data('user_'~func.rwurl(entry.name))|last.data|json_decode %}
<div class="card"> <div class="card-content"> <span class="card-title grey-text text-darken-4" style="font-size:20px"><img src="https://images.weserv.nl/?url={% if entry.name=='anonymous' %}https://i.imgur.com/09PPRoG.jpg{% elseif get_data_count('user_'~func.rwurl(entry.name))!='0' %}{% if udata.avt=="default" %}https://api.adorable.io/avatars/25/{{udata.nick|slice(0,1)|trim}}.png{% else %}{{udata.avt}}{% endif %}{% else %}https://i.imgur.com/tBWLw5o.jpg{% endif %}&w=25&h=25&t=square&mask=circle" style="width:25px;margin: -5px 0 0!important; vertical-align: middle;pointer-events:none" /> {% if entry.name=='anonymous' %}Một bạn đã nói{% elseif get_data_count('user_'~func.rwurl(entry.name))!='0' %}{% if udata.hide=='1' %}{{udata.name}}{% else %}Một bạn đã nói{% endif %}{% else %}<b style="color:red">BOT</b>{% endif %}: </span> <p>{{func.bbcode(entry.comment)}}
<div style='text-align: right;'><em><small>{{agos}}</small></em></div>
</p> </div> </div>
{% endif %} 
{% endfor %}
{% if ubot['xc'].time < "now"|date("U") and ubot['xc'].end != 'yes' %}
{% set id = func.get('guestbook')|split('@')[99]|trim %}
{{func.add('chat_'~id,'name','bot')}}
{{func.add('chat_'~id,'time',ubot['xc'].time)}}
{{func.add('chat_'~id,'comment','Rất tiếc, không có ai trả lời đúng câu hỏi vừa rồi. Đáp án đúng là: [b]'~ubot['xc'].word~'[/b]')}} 
{{func.add('bot','xc',{"id":ubot['xc'].id|trim,"time":"now"|date("U"),"word":xc.word,"raw_word":xc.raw_word,"end":"yes"})}}
{{func.up('guestbook',id,'up') }}
{% endif %}
{{func.paging('/talk?p=',p,page_max)}}