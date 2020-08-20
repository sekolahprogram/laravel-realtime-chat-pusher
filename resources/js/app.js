require('./bootstrap');

import Vue from 'vue'

new Vue({
    el: '#app',
    data: {
        id: document.getElementById('user_id').value,
        search: '',
        messages: [],
        users: [],
        form: {
            to_id: '',
            content: ''
        },
        isActive: null
    },
    mounted() {
        this.fetchUsers()
        this.fetchPusher()
    },
    methods: {
        fetchUsers() {
            let q = _.isEmpty(this.search) ? 'all' : this.search
            
            axios.get('/message/user/' + q).then(({ data }) => {
                this.users = data
            })
        },
        fetchMessages(id) {
            this.form.to_id = id
            axios.get('/message/user-message/' + id).then(({ data }) => {
                this.messages = data
                this.isActive = this.users.findIndex((s) => s.id === id)
                this.users[this.isActive].count = 0
            })
        },
        sendMessage() {
            axios.post('message/user-message', this.form).then(({ data }) => {
                this.pushMessage(data, data.to_id)
                this.form.content = ''
                this.search = ''
            })
        },
        fetchPusher() {
            Echo.channel('user-message.' + this.id)
                .listen('MessageEvent', (e) => {
                    this.pushMessage(e, e.from_id, 'push')
                })
        },
        pushMessage(data, user_id, action = '') {
            let index = this.users.findIndex((s) => s.id === user_id)

            if (index != -1 && action == 'push') {
                this.users.splice(index, 1)
            }

            /**
             * if untuk pesan submit
             */
            if (action == '') {
                this.users[index].content = data.content
                this.users[index].to_id = data.to_id

                let user = this.users[index]

                this.users.splice(index, 1)
                this.users.unshift(user)
            }

            /**
             * else untuk pesan dari laravel echo
             */
            else {
                this.users.unshift(data)
            }

            /**
             * Jika dia melihat pesan user
             */
            if (this.form.to_id != '') {
                index = this.users.findIndex((s) => s.id === this.form.to_id)

                this.users[index].count = 0
                this.isActive = index

                if (this.form.to_id == user_id) {

                    this.messages.push(data)

                    axios.get('/message/user-message/' + user_id + '/read')
    
                }

            }
        },
        scrollToEnd: function () {
            let container = this.$el.querySelector("#card-message-scroll");
            container.scrollTop = container.scrollHeight;
        }
    },
    watch: {
        search: _.debounce( function() {
            this.fetchUsers()
        }, 500),
        messages: _.debounce( function() {
            this.scrollToEnd()
        }, 10),
    }
})
