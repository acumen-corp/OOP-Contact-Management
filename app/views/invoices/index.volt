<h2>Your Contacts</h2>
<div align="right">
    {{ link_to("contacts/new", "Create contacts", "class": "btn btn-primary") }}
</div>

<div class="bs-example" data-example-id="hoverable-table">
         <table class="table table-hover">
                 <thead>
                     <tr>
                         <th>#</th>
                         <th>Name</th>
                         <th>Email</th>
                         <th>Address</th>
                         <th>Phone</th>
                         <th>Birthday</th>
                    </tr>
                  </thead>

                 <tbody>
                       {% for contact in contacts %}
                     <tr>
                         <th scope="row">{{contact.id}}</th>
                         <td> {{contact.name}} </td>
                         <td>{{contact.email}}</td>
                         <td>{{contact.address}}</td>
                         <td>{{contact.phone}}</td>
                         <td>{{contact.birthday}}</td>
                     </tr>
                        {% endfor %}
                 </tbody>
         </table>
 </div>
