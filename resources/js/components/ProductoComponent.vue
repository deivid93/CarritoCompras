<template>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex">
                <h1 class="justify-content-start flex-grow-1 mt-3 p-2"><b>Catalogo de Productos</b></h1>
                <div class="justify-content-end p-2"><i class="float-right far fa-user fa-4x"></i></div>
            </div>
            <div class="card-body">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" v-bind:class="{active:isAgregar}">
                        <a @click="agregar" class="">Nuevo Producto</a>
                    </li>
                    <li class="breadcrumb-item" v-bind:class="{active:isListado}">
                        <a @click="listado" class="">Listado de Productos</a>
                    </li>
                    <li class="breadcrumb-item" v-bind:class="{active:isCarrito}">
                        <a @click="carrito" class="">Carrito de Compras</a>
                    </li>
                </ol>
                <hr>
                <div v-if="modoAgregar">
                    <small class="text-left font-italic">Por favor Escriba los datos del Producto</small>
                    <br><br>
                    <div class="alert alert-primary" v-bind:hidden="isAlert" role="alert">
                        "{{message}}"
                    </div>

                    <form enctype="multipart/form-data" @submit.prevent="agregarProducto" class="form-group" >
                        <div class="form-group">
                            <label for="image">Imagen del Producto</label>
                            <input type="file"  @change="getImagen" class="form-control-file" id="imagen" aria-describedby="">
                        </div>
                        <figure>
                            <img width="200" :src="imagen" height="200"  alt="Imagen del producto">
                        </figure>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre</label>
                            <input type="text" v-model="producto.nombre" class="form-control" id="nombre" aria-describedby="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Descripcion del producto</label>
                            <input type="text" v-model="producto.descripcion" class="form-control" id="descripcion" aria-describedby="">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Precio del producto</label>
                            <input type="number" v-model="producto.precio" class="form-control" id="precio" aria-describedby="">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <div v-else-if="modoListado" >
                    <h2>LISTA DE PRODUCTOS</h2>
                    <hr>
                    <div v-if="productos.length" class="col-md-12">
                        <div class="row">

                            <div v-for="(i, index) in productos" :key="index" class="thumbnail col-md-3 mr-0" style="border: #1d643b">
                                <img :src="'/image/' + i.imagen" alt="" width="100px" height="100px">
                                <div class="caption">
                                    <h3>{{i.nombre}}</h3>
                                    <p>{{i.descripcion}}</p>
                                    <p><b>${{i.precio}}</b></p>
                                    <hr>
                                    <p>
                                        <a href="#" v-on:click="addCarrito(i)" data-toggle="modal" data-target="#carrito" class="btn btn-success">Añadir carrito</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <p>Aun no tienes productos!</p>
                    </div>
                </div>

                <div v-else >
                    <h2>Tu carrito de Compras!</h2>
                    <hr>
                    <div v-if="listCarrito.length" class="">
                        <div class="row">
                            <div v-for="(j, index) in listCarrito" :key="index" class="thumbnail col-md-12" style="border: #1d643b">
                                <!--<img :src="'/image/' + i.imagen" alt="" width="100px" height="100px">-->
                                <div class="caption">
                                    <h3><b>Nombre del producto</b> {{j.nombre}}</h3>
                                    <p><b>Descripcion</b> {{j.descripcion}}</p>
                                    <p><b>precio:</b>  ${{j.precio}}</p>
                                    <input type="number" v-model.number="j.cantidad">
                                    <button type="button" @click="j.cantidad = j.cantidad + 1" >+</button>
                                    <button type="button" @click="j.cantidad <= 0 ? j.cantidad = 0 : j.cantidad = j.cantidad - 1" >-</button>
                                    <hr>
                                    <hr>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4>Total Compra:  <b>{{ sumarProductos }} </b></h4>
                                <p>
                                    <a href="#" v-on:click="addOrden(listCarrito)" class="btn btn-success">Confirmar Orden</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <p>Aun no tienes items!</p>
                    </div>
                </div>
            </div>
            <!-- Modal-->
            <div class="modal fade" tabindex="-1" role="dialog" id="carrito" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Cuantos productos desea añadir ?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="listar(edit)" class="form-group" >
                                <input type="number" v-model.number="edit.cantidad">
                                <button type="button" @click="edit.cantidad = edit.cantidad + 1" >+</button>
                                <button type="button" @click="edit.cantidad <= 0 ? edit.cantidad = 0 : edit.cantidad = edit.cantidad - 1" >-</button>
                                <hr>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    let moment = require('moment')
    let modal = require('modal-js')
    export default {
        name: 'ProductoComponent',
        data() {
            return {
                total: 0,
                cantidad: 0,
                image_src: '/image/.bEUcr.png',
                imagenMiniatura: '',
                moment,
                modal,
                productos: [],
                message: '',
                producto: {
                    imagen: '',
                    nombre: '',
                    descripcion: '',
                    precio: ''
                },
                isAgregar: false,
                isListado: false,
                isCarrito: false,
                modoAgregar: false,
                modoListado:false,
                isAlert: true,
                listCarrito: [],
                edit: {id: '', nombre:'', descripcion:'', precio:'', cantidad: '' },
                ids_productos: []
            }
        },
        created() {
            this.isAgregar = true
            this.modoAgregar = true
            isAlert: true
            this.getProductos()

        },
        computed:{
            imagen(){
                return this.imagenMiniatura
            },
            sumarProductos(){
                this.total = 0;

                for (const c  in this.listCarrito) {
                    console.log(this.listCarrito[c].cantidad)
                    this.total = this.total + this.listCarrito[c].cantidad
                }
                return this.total
            }
        },
        methods: {
            agregar(){
                console.log('click Agregar')
                this.isAgregar == true
                this.isListado = false
                this.isCarrito = false
                this.modoAgregar = true
            },
            listado(){
                this.getProductos()
                this.isAgregar == false
                this.isCarrito = false
                this.isListado = true
                this.modoAgregar = false
                this.modoListado = true
            },
            carrito(){

                this.isAgregar == false
                this.isListado = false
                this.isCarrito = true
                this.modoAgregar = false
                this.modoListado = false
            },
            agregarProducto(){
                if(this.producto.imagen == '' || this.producto.nombre == '' || this.producto.descripcion == '' || this.producto.precio == ''){
                    alert('Es necesario completar todos los campos')
                    return
                }

                const producto = this.producto
                this.producto = {imagen: '', nombre: '', descripcion: '', precio: ''};
                axios.post('/api/producto/new', producto).then(
                    data=> {
                        //console.log(data.status)
                        this.message = 'Producto Agregado!'
                        this.isAlert = false
                        setTimeout(()=>{this.isAlert = true},4000 )
                    }
                ).catch(
                    err=> {
                        console.log(err)
                    }
                )
            },
            getProductos(){
                axios.get('/api/productos').then(
                    data => {
                        console.log(data.data);
                        this.productos = data.data
                    }
                ).catch(
                    err=> {
                        console.log(err)}
                )
            },
            getImagen(e){
                let file = e.target.files[0]
                console.log(file)
                //this.producto.imagen = file
                this.uploadImage(file)

            },
            uploadImage(file){
                let leer = new FileReader();
                leer.onload= (e) => {
                    this.imagenMiniatura = e.target.result;
                    this.producto.imagen = e.target.result;
                }
                leer.readAsDataURL(file)
            },
            addCarrito(form){
                this.edit.id = form.id
                this.edit.nombre = form.nombre
                this.edit.descripcion = form.descripcion
                this.edit.precio = form.precio
                this.edit.cantidad = form.cantidad
                $("#carrito").modal("show")
            },
            listar(edit){
                $("#carrito").modal("hide")
                this.listCarrito.push(
                    {id: edit.id, nombre: edit.nombre, descripcion: edit.descripcion, precio: edit.precio, cantidad: edit.cantidad}
                )
                console.log(this.listCarrito)
            },
            addOrden(listCarrito){
                for (const c  in listCarrito) {
                    this.ids_productos.push(listCarrito[c].id)
                }
                //console.log(this.ids_productos);

                axios.post('/api/orden/new', this.ids_productos).then(
                    data=> {
                        //console.log(data.status)
                        alert('Orden Generada con exito!')
                        this.message = 'Orden Generada con exito!'
                        this.isAlert = false
                        setTimeout(()=>{this.isAlert = true},4000 )
                    }
                ).catch(
                    err=> {
                        console.log(err)
                    }
                )
            }
        }
    }
</script>
