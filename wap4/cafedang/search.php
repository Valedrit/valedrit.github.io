{% use '_includes_forum' %}
{% from 'func.twig' import mi_get,mi_up,k_del,get,html_decode %}
{% from 'function.twig' import add,mi_add,slug,time,description %}
{% import '_functions' as func %}
{% set url = get_uri_segments() %}
{% set title = 'Tìm kiếm' %}
{% set data = mi_get('show_blog')|split(' @ ')|reverse  %}
{% set domain = current_url|split('/').0~"//"~current_url|split('/').2 %}
{% set data1 %}{% for i in data %}{% set title = get('blog_'~i|trim,'title') %}{% set content = get('blog_'~i|trim,'content') %}{% set key = get_get('key') %}
{% if key|length>'0' and key|lower in title|trim|lower or key|length>'0' and key|lower in content|trim|lower %}{% if loop.last==false %}{{i|trim}}.{% endif %}{% endif %}{% endfor %}{% endset %}
{% set count = data1|split('.')|length-1 %}
{{block('head')}}
<div class="phdr"><a href="/"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a> » <a href="/library">Thư viện</a> » Tìm kiếm</div>
<div class="menu" style="text-align: center;"><form action="" method="get"><input type="text" id="search-input" name="key" value="{{get_get('key')}}" placeholder="Nhập từ khóa cần tìm..."><button type="submit"><i class="fa fa-search" aria-hidden="true"></i> Tìm</button></form></div>
<div id="results-container"></div>
{% if count > '0' %}
<div class="list1" align="center"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Có {{count}} kết quả được tìm thấy</div>
{% else %}
{% if get_get('key')|length > 0 %}
<div class="list1" align="center"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i> Không tìm thấy kết quả nào </div>
{% endif %}
{% endif %}
 {% set data=data1|split('.') %}
 {% set total=data|length-1 %} 
{% set per = '10' %}
 {% set page_max=total//per %}
{% if total//per != total/per %}
{% set page_max=total//per+1 %}
{% endif %}
{% set p=get_get('p')|default('1') %} 
{% if p matches '/[a-zA-z]|%/' or p<1 %}
{% set p=1 %}
{% endif %}
{% if p>page_max %}
{% set p=page_max %}
{% endif %}
{% set st=p*per-per %}
{% for id in data|slice(0,total)|slice(st,per) %}
{% set blog = 'blog_'~id|trim %}
{% set title = get(blog,'title') %}
{% set slug = get(blog,'slug') %}
<div class="list-login pre"><i class="fa fa-rss" aria-hidden="true"></i> <a href="/library/{{id|trim}}-{{slug}}">{{func.pre(title)}}</a></div>
{% endfor %}
{% if page_max>per %}
{% set page_max=per %} 
 {% endif %} 
 {{func.paging(url|join('/')~'?key='~get_get('key')~'&p',p,page_max)}}
{{block('end')}}