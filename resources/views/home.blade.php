@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">Messages</div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" id="user_id" value="{{ auth()->user()->id }}">
                    <div class="form-group">
                        <input v-model="search" type="search" class="form-control" placeholder="Cari user">
                    </div>
                    <ul class="list-user list-group list-group-flush">
                        <a v-for="(user, index) in users" v-bind:key="index"
                            v-if="user.id != id"
                            :class="['list-group-item d-flex justify-content-between align-items-center list-group-item-action', {
                                'active': isActive === index && search == '' ? true : false
                            }]"
                            v-on:click="fetchMessages(user.id)">
                            <div class="media">
                                <img class="mr-3 rounded-sm rounded-circle" :src="user.avatar" alt="profile">
                                <div class="media-body">
                                    <strong>@{{ user.name }}</strong>
                                    <p v-if="user.content">
                                        @{{
                                            (id != user.to_id ? 'Anda: ' : '')
                                            + (user.content.length > 20 
                                            ? user.content.substr(0, 20) + '...' 
                                            : user.content)
                                        }}
                                    </p>
                                </div>
                            </div>
                            <span v-if="user.count" class="badge badge-primary badge-pill mr-3">@{{ user.count }}</span>
                        </a>
                    </ul>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body card-message" id="card-message-scroll">
                            <ul v-if="isActive != null" class="list-group list-group-flush">
                                <div v-for="(message, index) in messages" v-bind:key="index">
                                    <li v-if="message.from_id != {{ auth()->user()->id }}" class="list-group-item">
                                        <div class="list-message-item">
                                            <div class="media">
                                                <img class="mr-3 rounded-sm rounded-circle" :src="message.avatar" alt="profile">
                                                <div class="media-body">
                                                    <div class="alert alert-primary mb-0">
                                                        @{{ message.content }}
                                                    </div>
                                                    <small><i>@{{ new Date(message.created_at).toLocaleDateString()}}</i></small>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li v-else class="list-group-item">
                                        <div class="list-message-item right">
                                            <div class="alert alert-secondary mb-0">
                                                @{{ message.content }}
                                            </div>
                                            <small class="float-right"><i>@{{ new Date(message.created_at).toLocaleDateString()}}</i></small>
                                        </div>
                                    </li>
                                </div>
                            </ul>
                            <h5 v-else class="text-center">Pilih user untuk mengirim pesan</h5>
                        </div>
                    </div>
                    <div v-if="isActive != null" class="form-group mt-3">
                        <form @submit.prevent="sendMessage">
                            <input v-model="form.content" type="text" class="form-control" placeholder="Tulis..." required>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
