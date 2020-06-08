{% import '_functions' as func %}
{% from '_functions' import get,ago,bbcode %}
{% import '_avatar' as avatar %}
{% import 'chat_module_bot' as bot %}
{% set login = func.signin()|trim %}
{% set name = login %}
{% set ubot = get_data('user_apple')[0].data|json_decode %}
{% set id = func.get('xep_chu')|split('@')[19]|trim %}
{% set msg = get_post('msg') %}
{% set now = "now"|date("U") %}
{# {% if request_method()|lower=='POST' %} #}
{% if msg != '' and msg != '\r\n' and msg!=null %}
{# {{func.add('user_'~login,'new',msg)}}
{% if msg and func.get('user_'~login,'old')|trim|raw != func.get('user_'~login,'new')|trim|raw %} #}
{% set comment = {"name" :name,"time":now,"comment":msg} %}
{{func.add('xc_'~id,'name',name)}}
{{func.add('xc_'~id,'time',now)}}
{{func.add('xc_'~id,'comment',msg)}} 
{{func.up('xep_chu',id,'up') }}
{{func.add('user_'~login,'old',msg)}} 
{{func.add('user_'~login,'postguest',get('user_'~login,'postguest')|trim+1)}}
{{bot.xepchu(msg,'apple')}}
{# {% endif %} #}
{% endif %}
{# {% endif %} #}
{% set data= func.get('xep_chu')|trim|split('@') %}
{% set total=data|length-1 %} 
 {% set page_max=total//10 %}
{% if total//10 != total/10 %}
{% set page_max=total//10+1 %}
{% endif %}
 {% set url=get_uri_segments() %}
{% set p=url[1]|default(1) %} 

{% if p matches '/[a-zA-z]|%/' or p<1 %}
{% set p=1 %}
{% endif %}
{% if p>page_max %}
{% set p=page_max %}
{% endif %}
{% set st=p*10-10 %}
{% if ubot['xc'].time >= "now"|date("U") %}
<div class="rmenu" align="center">
{% if ubot['xc'].time=="now"|date("U") %}
Hết giờ !!!
{% else %}
Sắp xếp các chữ sau thành từ hoặc cụm từ hoàn chỉnh:<br/>{{ubot['xc'].quest}}
<br/>Còn: {{(ubot['xc'].time)-("now"|date("U"))}} giây nữa
{% endif %}
</div>
{% endif %}

{% for id in data|slice(0,total)|slice(st,10) %}
{% set entry = get_data('xc_'~id|trim)[0].data|json_decode %}
{% set user='user_'~entry.name %}
{% set info=get_data(user)[0].data|json_decode %}
{% set nd = entry.comment %}
{% set time = entry.time %}
{% set jun = now-time %}
{% if jun > 1 %}
{% set agos = ago(time) %}
{% else %}
{% set agos = 'vừa xong' %}
{% endif %}
{% if entry.name %}
<div class="comment-head">{# {{avatar.sex(entry.name)}} #} <a href="/user/{{entry.name}}.html">
{% if func.get(user,'ban') =='1' %}<s>{{get(user,'name')}}</s>{% else %}{{avatar.mau_nick(entry.name,info.right)}}{% endif %}
</a> {#<span name="online">{% if info['on'] < ('now'|date('U')-300) %}<font color="red"><i class="fa fa-toggle-off" aria-hidden="true"></i></font>{% else %}<font color="green"><i class="fa fa-toggle-on" aria-hidden="true"></i></font>{% endif %}</span>#}<span class="comment-time"><i class="fa fa-clock-o"></i> {{agos}} </span></div><div class="menu comment-content"> {{bbcode(nd|raw)}}{% if login!=entry.name %} <br/><div align="right"><a href="javascript:tag('@{{entry.name}} ', '')">[ Tag ]</a></div>{% endif %}</div>
{% endif %} 
{% endfor %}
{% if ubot['xc'].time < "now"|date("U") and ubot['xc'].end != 'yes' %}
{% set id = func.get('xep_chu')|split('@')[19]|trim %}
{{func.add('xc_'~id,'name','apple')}}
{{func.add('xc_'~id,'time',ubot['xc'].time)}}
{{func.add('xc_'~id,'comment','Rất tiếc, không có ai trả lời đúng câu hỏi vừa rồi. Đáp án đúng là: [b]'~ubot['xc'].word~'[/b]')}} 
{{func.add('user_apple','xc',{"id":ubot['xc'].id|trim,"time":"now"|date("U"),"word":xc.word,"raw_word":xc.raw_word,"end":"yes"})}}
{{func.up('xep_chu',id,'up') }}
{% endif %}
{% if login and login not in func.get('show_online')|split('@') %}
{{func.up('show_online',login,'up')}}
{% endif %}