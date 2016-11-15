
<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("contacts", "&larr; Go Back") }}
    </li>
</ul>

<div class="delete-contact" >
	<a href="/contacts/delete/{{ contact.id }}"  class="btn btn-danger" onclick="return confirm('Confirm Delete')">
	<i class="glyphicon glyphicon-remove"></i> Delete Contact</a>
</div>

<h2>Contact Details</h2>

<h1> {{ contact.name}} </h1>

<p><strong>Email:</strong> {{ contact.email}} </p>
<p><strong>Phone Number:</strong> {{ contact.telephone}} </p>
<p><strong>Address:</strong> {{ contact.address}} </p>
<br>

<p><strong>Birthday:</strong> {{ contact.birthday}} </p>
<br>

<h2> Relationships:</h2>
{% for relationship in relationships %}
	<p><strong>{{ relationship.name }}</strong> ({{ relationship.relationship }})
	{# Build the delete button with deleteRelationship route. #}
	<a href="/contacts/deleteRelationship/{{ relationship.id }}/{{ relationship.contact1_id }}" class="btn btn-danger" onclick="return confirm('Confirm delete {{ relationship.name}} from relationships.')"><i class="glyphicon glyphicon-remove"></i> Delete</a>
{% endfor %}
<br /> <br />

{{ form("contacts/createrelationship", ['class': 'form-inline'])  }}

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

{{ content() }}
