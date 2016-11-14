
<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("contacts", "&larr; Go Back") }}
    </li>
</ul>

<div class="delete-contact">
	<a href="/contacts/delete/$id" class="btn btn-danger" onclick="return confirm('Confirm Delete')">
	<i class="glyphicon glyphicon-remove"></i> Delete Contact</a>
</div>

<h1>Contact Details</h1>

<h2> {{ contact.name}} </h2>

<p><strong>Email:</strong> {{ contact.email}} </p>
<p><strong>Phone Number:</strong> {{ contact.telephone}} </p>
<p><strong>Address:</strong> {{ contact.address}} </p>
<br>

<p><strong>Birthday:</strong> {{ contact.birthday}} </p>
<br>

<h2> Relationships:</h2>
{% for relationship in relationships %}
	<h3> {{ relationship.name }} ({{relationship.relationship }})</h3>
{% endfor %}
<br/>

<h2>New Relationship</h2>

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

{{ content() }}
