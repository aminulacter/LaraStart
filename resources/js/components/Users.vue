<template>
    <div class="container">
        <div class="row mt-5">
             <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                  <button class="btn btn-success" @click="openModal"> Add New <i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Registered At</th>
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user,index) in users" :key="index">
                      <td>{{ index+1 }}</td>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.type | upText }}</td>
                      <td>{{ user.updated_at | myDate }}</td>
                     
                      <td>
                          <a href="#" @click.prevent="openModal(user)">
                              <i class="fas fa-edit blue"></i>
                          </a>/
                          <a href="#" @click.prevent="deleteUser(user.id)">
                              <i class="fas fa-trash red"></i>
                          </a>
                      </td>
                    </tr>
                   
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
            
        </div>
       <!-- Button trigger modal -->
       

<!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New </h5> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="createUser">
               <div class="modal-body">
               <div class="form-group">
               
                <input v-model="form.name" type="text" name="name"
                    placeholder="Name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
                </div>
                 <div class="form-group">
               
                <input v-model="form.email" type="email" name="email"
                    placeholder="Email Address"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                <has-error :form="form" field="email"></has-error>
                </div>
                
                 
                 <div class="form-group">
               
                <textarea v-model="form.bio" type="text" name="bio"
                    placeholder="Biography"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                <has-error :form="form" field="bio"></has-error>
                </div>
                <div class="form-group">
               
                <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                    <option value="">Select User Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="author">Author</option>
                </select>
                <has-error :form="form" field="type"></has-error>
                </div>
                 <div class="form-group">
               
                <input v-model="form.password" type="password" name="password"
                    placeholder="Password"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                <has-error :form="form" field="password"></has-error>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">{{ oparation }}</button>
            </div>
            </form>
           
            </div>
        </div>
        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
               oparation: 'Create',
               currentSelected: 0,
               users: [],
               form: new Form({
                   name: '',
                   email: '',
                   password:'',
                   type: '',
                   bio: '',
                   photo: ''
                })
            }
        },
        methods:{
          openModal(user)
          {
            this.form.reset();
            this.oparation = "Create"
            if(user.id)
              {
                this.form.fill(user);
                this.oparation = "Update"
                this.currentSelected = user.id;
                console.log(user)
              }
             
            $('#addNew').modal('show')
          },
          createUser()
          {
            this.$Progress.start()
            
            if(this.oparation == "Create")
            {
              this.form.post('api/user')
            .then(() =>this.completLoad("Created Successfully"))
            .catch(() =>this.uncompletLoad());
            }
            else{
               this.form.patch(`api/user/${this.currentSelected}`)
            .then(() =>this.completLoad("Updated successfully"))
            .catch(() =>this.uncompletLoad());
            }
           //$('#addNew').modal('hide')
          },
          completLoad(message)
          {
            
            Toast.fire({
            icon: 'success',
            title: message
            })
            this.$Progress.finish()
            this.loadUsers();
            $('#addNew').modal('hide')
            // $(this.$refs.vuemodal).on("hidden.bs.modal");
          },
          uncompletLoad()
          {
            Toast.fire({
            icon: 'error',
            title: 'User cannot be created'
            })
            this.$Progress.finish()
           // this.loadUsers();
            //$('#addNew').modal('hide')
          },
          loadUsers()
          {
              axios.get("api/user").then(({data}) => {
                  this.users = data.data
                  
                  })
             
          },
          deleteUser(id)
          {
            axios.delete(`api/user/${id}`)
            .then((response) => { 
              console.log(response)
              Toast.fire({
              icon: 'success',
              title: 'User Deleted successfully'
              })
               this.loadUsers();

            }).catch((error) =>{

            })
            console.log("api/user/" + id);
          }
        },
        created() {
           this.loadUsers();
           //setInterval(() => this.loadUsers(),3000);
        }
    }
</script>
