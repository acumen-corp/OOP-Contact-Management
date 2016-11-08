
{{ content() }}

{{ form("contacts/create", ['class': 'form-inline']) }}

    <ul class="pager">
        <li class="previous pull-left">
            {{ link_to("contacts", "&larr; Go Back") }}
        </li>
    </ul>

    <fieldset  class="form-inline">

    {% for element in form %}
        {% if is_a(element, 'Phalcon\Forms\Element\Hidden') %}
            {{ element }}
        {% else %}
            <div class="form-group">
                {{ element.label() }}
                {{ element.render(['class': 'form-control']) }}
            </div>
        {% endif %}
    {% endfor %}

    </fieldset>

    <ul class="pager">
        <li class="">
            {{ submit_button("Save", "class": "btn btn-success") }}
        </li>
    </ul>


</form>
