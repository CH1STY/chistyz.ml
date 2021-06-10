<template>
    <div class="container-fluid ">
        <navbar/>
        <h2 class="text-center text-uppercase h3">Welcome {{username}}</h2>
        <div class="row">
            <div class="col-md-7 btmMar" >
                <div class="card bg-dark">
                    <div class="card-body">
                        <form @submit.prevent="submit">
                                <div class="card-header h3 text-center text-white text-uppercase">
                                    ADD TO DO
                                </div>
                                    <div class="form-group">
                                        <label >Title</label>
                                        <input type="text"  class="form-control" v-model="form.title" name="title"   placeholder="Enter Title"/>
                                        <small v-if="errors.title" class="form-text text-danger" >{{errors.title[0]}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label >Details <span :class="{'text-danger' : isExceedChar==true}">({{this.charcount}})</span> </label>
                                        <input :onChange="recount()" type="text"  class="form-control" v-model="form.details"  name="details"   placeholder="Enter Details"/>
                                        <small v-if="errors.details" class="form-text text-danger"  >{{errors.details[0]}}</small>
                                    </div>
                                    <div class="form-group">
                                        <label >Date and Time</label>
                                        <input type="datetime-local" v-model="form.date"  class="form-control"  name="date"   placeholder="Enter Date and Time"/>
                                        <small v-if="errors.date" class="form-text text-danger">{{errors.date[0]}}</small>
                                    </div>
                                
                                    <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>              
            </div>
            <div class="col-md-5 overflow-auto btmMar border"  style=" max-height:30rem;">
                <div class="card-header h4 text-center text-info text-uppercase">
                    TO-DO List
                </div>
                <div v-for="todo in todos" :key="todo.id" class="card bg-dark ">
                    <div class="card-body greenBorder">
                        <div class="float-right" style="display:inline">
                            <button v-on:click="deleteTodo(todo.id,todo.header)" class="btn btn-outline-danger">
                                <svg  xmlns="http://www.w3.org/2000/svg" width="12px" height="12px" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>
                            </button>
                        </div>
                        <h6> <span class="text-info">Title: </span>{{todo.header}}</h6>
                        <p><span class="text-warning">Details: </span>{{todo.details}}</p>
                        <p><span class="text-success">Date: </span>{{dateBeauty(todo.todo_date)}}</p>
                    </div>
                </div>                            
            </div>
        </div>
    </div>
</template>

<script>
import navbar from './navbar.vue';

export default {
  components: { navbar },
    beforeCreate()
    {
        if(!User.loggedIn())
        {
            this.$router.push({name:'login'});
        }
    },
    created(){
        this.getTodo();
    },
    data(){
        return{
            form:{
                title: null,
                details:"",
                date:null,
            },
            todos : {},
            username: localStorage.getItem('user'),
            errors:{},
            charcount: "Remaining 50",
            isExceedChar:false,
        }
    },
    methods:{

        getTodo()
        {
            axios({
                method: 'get',
                url: '/api/user/getTodo',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')} `
                }
            })
            .then(res=>this.todos=res.data)
        },
        submit()
        {
            axios({
                    method: 'post',
                    url: '/api/user/addTodo',
                    data: this.form,
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')} `
                    }
            })
            .then(res=>{
                if(res.data=='Success')
                {
                    Toast.fire({
                        icon: 'success',
                        title: 'TODO ADDED',
                    })
                    this.form.title = null;                   
                    this.form.date = null;                   
                    this.form.details = ""; 
                    this.errors = {};
                    this.getTodo();                  
                }
                else
                {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Invalid',
                    })
                }
            })
            .catch(error=>{
                this.errors = error.response.data.errors;
                Toast.fire({
                    icon: 'warning',
                    title: 'Invalid',
                })
            })           

        },
        deleteTodo(id,title)
        {
            Swal.fire({
            title: `Delete Todo "${title}"`,
            text: "This Action Can't be Reverted",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => 
            {
                if (result.isConfirmed) 
                {
                    axios({
                        method: 'post',
                        url : `/api/user/deleteTodo/${id}`,
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('token')} `
                        }
                    })
                    .then(res=>
                    {
                        if(res.data=='Success')
                        {
                            this.getTodo()
                            Swal.fire(
                            'Deleted!',
                            `Todo "${title}" Deleted`,
                            'success'
                            )
                        }
                    })

                }
            })             
            
        },
        dateBeauty(datestring)
        {
            let date = new Date(datestring);
        

            return String(date).substr(0,24);
        },
        recount()
        {
            let strlen = this.form.details.length;
           
            if(strlen>50)
            {
                this.charcount = "Exceeds " + (50-strlen) + " Character";
                this.isExceedChar = true; 
            }
            else
            {
                this.charcount = "Remaining "+(50-strlen);
                this.isExceedChar = false;
            }
        }
        
    }
}
</script>


<style scoped>
.row{
    margin: auto;
}
.btmMar{
    margin-bottom: 20px;
}
.border{
    box-shadow: 
    0 0 1px #fff,
    0 0 2px #fff,
    0 0 3px #fff,
    0 0 4px #0fa,
    0 0 5px #0fa,
    0 0 6px #0fa,
    0 0 7px #0fa,
    0 0 8px #0fa;
}

.greenBorder{
    margin-bottom:5px;
    border: 2px solid rgb(9, 248, 128);
}
</style>
