{{ content() }}

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("contacts/index", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ link_to("contacts/new", "Create Contact",  "<i class='glyphicon glyphicon-edit' ></i>" ) }}
    </li>
</ul>

{{ form("contacts/search", 'class': 'form-inline') }}

<h2> Manage Contacts - Filtered </h2>

<fieldset class="pull-right">

<div class="form-group">
    <label for="search" class="control-label">Search: </label>
    <div class="controls">
        <input id="name" name="name" type="text">
        <input id="address" name="search[address]"  type="Hidden">
        <input id="telephone" name="search[telephone]"  type="Hidden">
        <input id="email" name="search[email]"  type="Hidden">
        <input id="birthday" name="search[birthday]"  type="Hidden">
        </div>
</div>

<div class="form-group">
<br />
    {{ submit_button("Search", "class": "btn btn-primary") }}
</div>
</fieldset>
</form>

<br />
<br />
<br />
<br />

{% for contact in page.items %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Birthday</th>
        </tr>
    </thead>
{% endif %}
    <tbody>
        <tr>
            <td>{{ contact.id }}</td>
            <td>
                {% if  birthday_date == contact.birthday %}
                 <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                {% endif %}
                  {{ contact.name }}
            </td>
            <td>{{ contact.email }}</td>
            <td>{{ contact.telephone }}</td>
            <td>{{ contact.address }}</td>
            <td>{{ contact.birthday }}</td>
              <td width="7%">{{ link_to("contacts/details/" ~ contact.id, '<i class="glyphicon glyphicon-edit"></i> Details', "class": "btn btn-primary") }}</td>
            <td width="7%">{{ link_to("contacts/edit/" ~ contact.id, '<i class="glyphicon glyphicon-edit"></i> Edit', "class": "btn btn-warning") }}</td>
            <td width="7%">{{ link_to("contacts/delete/" ~ contact.id, '<i class="glyphicon glyphicon-remove"></i> Delete', "class": "btn btn-danger") }}</td>
        </tr>
    </tbody>
{% if loop.last %}
    <tbody>
        <tr>
        <td colspan="4" align="left">
          <p>  <span class="glyphicon glyphicon-star" aria-hidden="true"></span> Denotes that its their Birthday Today!  </p>
        </td>
            <td colspan="7" align="right">
                <div class="btn-group">
                    {{ link_to("contacts/search", '<i class="icon-fast-backward"></i> First', "class": "btn btn-default") }}
                    {{ link_to("contacts/search?page=" ~ page.before, '<i class="icon-step-backward"></i> Previous', "class": "btn btn-default") }}
                    {{ link_to("contacts/search?page=" ~ page.next, '<i class="icon-step-forward"></i> Next', "class": "btn btn-default") }}
                    {{ link_to("contacts/search?page=" ~ page.last, '<i class="icon-fast-forward"></i> Last', "class": "btn btn-default") }}
                    <span class="help-inline">{{ page.current }}/{{ page.total_pages }}</span>
                </div>
            </td>
        </tr>
    <tbody>
</table>
{% endif %}
{% else %}
    No contacts are recorded
{% endfor %}
