<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12" v-if="!isLoading">
                <h4 class="text-body-emphasis">{{ form.name }}</h4>
                <p>{{ form.description }}</p>
                <div class="card">
                    <div class="card-body">
                        <div class="form-floating mb-3" v-for="(field, i) in form.fields" :key="i">
                            <input type="text" class="form-control" v-model="field.feedback_text" :id="field.id"
                                   :placeholder="field.label"
                            >
                            <label :for="field.id">{{ field.label }}</label>
                        </div>
                        <button type="button" @click="submitFeedback" class="btn btn-primary float-end my-3"> Submit
                        </button>
                    </div>
                </div>
            </div>
            <div class="text-center" v-else>Loading...</div>
        </div>
    </div>
</template>

<script>
import {get, post} from "../../utils/fetchAPI.js";
import {errorToast, successToast} from "../../utils/swalUtil.js";

export default {
    name: "SubmitFeedback",
    data() {
        return {
            form: {},
            errors: [],
            isLoading: false,
            feedbackForm: {}
        }
    },
    created() {
        this.getForm()
    },
    methods: {
        submitFeedback() {
            post('feedbacks', this.form).then(res => {
                console.log(res)
                this.$router.push('/')
                successToast(res?.data?.message)
            }).catch((errors) => {
                errorToast(errors?.response?.data?.message)
            })
        },
        async getForm() {
            this.isLoading = true
            await get(`forms/${this.$route.params.id}`)
                .then(res => {
                    // console.log(res)
                    this.form = res.data.data
                }).catch(errors => {
                    console.log(errors)
                })
                .finally(() => {
                    this.isLoading = false
                })

        },
    }
}
</script>

<style scoped>

</style>
