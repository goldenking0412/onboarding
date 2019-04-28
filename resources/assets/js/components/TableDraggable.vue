




<template>
    <draggable :list="sections" :options="{animation:200,handle:'.dragging-hand'}" :element="'ul'" @change="update">
        <li class="top-draggable-section mb-2" v-for="item in sections" :data-id="item.id">
            <span class="dragging-hand">
                <svg class="draggable-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100" viewBox="0 0 100 100"><g><g transform="translate(50 50) scale(0.69 0.69) rotate(0) translate(-50 -50)" style="fill:#000000"><svg fill="#000000" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" version="1.1" x="0px" y="0px"><title>Drag</title><desc>Created with Sketch.</desc><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(96.000000, 28.000000)" fill="#000000"><circle cx="45" cy="45" r="45"></circle><circle cx="274" cy="45" r="45"></circle><circle cx="45" cy="228" r="45"></circle><circle cx="274" cy="228" r="45"></circle><circle cx="45" cy="411" r="45"></circle><circle cx="274" cy="411" r="45"></circle></g></g></svg></g></g></svg>
                <b>{{ item.name }}</b>
            </span>
             - <a class="badge badge-secondary" :href="'/admin/survey-question/' + item.id + '/edit'">Edit</a> | <a class="small" :href="'/admin/survey-question/' + item.id + '/delete'">Delete</a>
            <draggable :list="item.questions" :options="{group:'allquestions'}" :element="'ul'"  @change="updateQuestions($event)">
                <li v-for="question in item.questions" :data-id="question.id">{{ question.question }} 
                    <!-- <a class="badge badge-secondary" :href="'/admin/survey-question/' + item.id + '/edit'">Edit</a> | <a class="small" :href="'/admin/survey-question/' + item.id + '/delete'">Delete</a> -->
                </li>
            </draggable>
        </li>
    </draggable>
</template>

<script>
    import draggable from 'vuedraggable'
    export default {
        components: {
            draggable
        },
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                sections: [],
                csrf: document.head.querySelector('meta[name="csrf_token"]').content
            };
        },
        created() {
            this.fetchQuestionSections();
        },
        methods: {
            fetchQuestionSections() {
                axios.get('/admin/survey-list/2')
                    .then((res) => {
                            this.sections = res.data;
                            this.loading = false;
                    })
                    .catch((err) => console.error(err));;
            },
            update() {
                this.sections.map((section, index) => {
                    section.section_order = index + 1;
                })
                // for (var i = this.sections.length - 1; i >= 0; i--) {
                //     console.log(this.sections[i].questions)
                //     this.sections[i].questions.map((question, index) => {
                //         question.question_order = index + 1;
                //     })
                // }

                axios.post('/admin/survey/update-all', {
                    sections: this.sections
                }).then((response) => {
                    console.log('success')
                })
            },
            updateQuestions(event) {
                // let id = event.item.getAttribute('data-id');
                // console.log(group);
            }
        },
        
    }
</script>
