{% use '_blocks' %}
{% set domain = current_url|split('/').2 %}
{% set website = domain|split('.').0 %}
{% set title = 'Điều Khoản Và Điều Kiện - '~website|upper %}
{{block('head')}}
{{block('rules')}}
{{block('end')}}