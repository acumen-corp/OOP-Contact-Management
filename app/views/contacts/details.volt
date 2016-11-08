
<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("contacts", "&larr; Go Back") }}
    </li>
</ul>

{{ content() }}


{# note: this is a comment

<h2>Contact Details</h2>

{% for contact in contacts  %}

<h1> {{ contact.name}} </h1>
<p><strong>Email:</strong> {{ contact.email}} </p>
<p><strong>Phone Number:</strong> {{ contact.telephone}} </p>
<p><strong>Address:</strong> {{ contact.address}} </p>
<br>
<p><strong>Birthday:</strong> {{ contact.birthday}} </p>
{% endfor %}

<br>

<h2> Relationships:</h2>
{% for contact in relationships %}

<h1> {{ contact.name }} </h1>

{% endfor %}

#}


{{ form("contacts/createrelationship", ['class': 'form-inline']) }}


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
    <div class="form-group">
       {{ submit_button("Add Relationship", "class": "btn btn-success") }}
     </div>
    </fieldset>



</form>
