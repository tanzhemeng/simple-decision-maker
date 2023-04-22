<script setup>
import { reactive, ref, computed } from 'vue'
import { Head } from '@inertiajs/vue3'
import AnswerModal from '@/Components/DecisionMaker/AnswerModal.vue'

const countOptions = [2,3,4,5,6,7,8,9,10]

const normalLabelClass = 'text-gray-900 dark:text-white'
const errorLabelClass = 'text-red-700 dark:text-red-500'

const normalInputClass = 'bg-gray-50 border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
const errorInputClass = 'bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 dark:bg-red-100 dark:border-red-400'

const submitting = ref(false)
const answerModal = ref(null)

const inputs = reactive({
	question: 'Should I go?',
	count: 2,
	choices: ['Yes', 'No'],
})

const validation = reactive({
	message: '',
	errors: {},
})

const result = reactive({
	question: '',
	answer: '',
})

const choicesCount = computed(() => {
	return inputs.choices.length;
})

function getAnswer() {
	resetValidation();
	submitting.value = true;

	axios.post('/', inputs)
		.then((response) => {
			result.question = response.data.question;
			result.answer = response.data.answer;
			answerModal.value.show();
		})
		.catch((error) => {
			console.log(error);
			if (error.response) {
				if (error.response.status === 422) {
					validation.message = error.response.data.message;
					validation.errors = error.response.data.errors;
				}
			}
		})
		.finally(() => {
			submitting.value = false;
		});
}

function hasError(field) {
	return Object.keys(validation.errors).some((k) => { return k.startsWith(field) });
}

function getError(field) {
	return Object.entries(validation.errors).find(([k, v]) => { return k.startsWith(field) })[1][0];
}

function newQuestion() {
	resetInputs();
	resetValidation();
}

function resetInputs() {
	inputs.question = '';
	inputs.count = 2;
	inputs.choices = ['', ''];
}

function resetValidation() {
	validation.message = '';
	validation.errors = {};
}

function onCountChange(event) {
	resetValidation();

	if (inputs.choices.length > inputs.count) {
		removeChoices(inputs.choices.length - inputs.count);
	}

	if (inputs.choices.length < inputs.count) {
		addChoices(inputs.count - inputs.choices.length);
	}
}

function addChoices(count) {
	let toBeAdded = Array(count).fill('');
	inputs.choices.push(...toBeAdded);
}

function removeChoices(count) {
	inputs.choices.splice(inputs.choices.length - count, count);
}
</script>

<template>
	<Head>
		<title>Simple Decision Maker</title>
	</Head>

	<div class="container mx-auto">
		<div class="my-16 mx-4">
			<div class="mb-8">
				<h1 class="text-5xl font-extrabold dark:text-white">Simple Decision Maker</h1>
			</div>

			<form @submit.prevent="getAnswer">
				<div class="mb-4">
					<label
						class="block mb-2 text-sm font-medium"
						:class="[hasError('question') ? errorLabelClass : normalLabelClass]"
						for="question"
					>What is your question?</label>

					<div class="mb-2">
						<input
							class="border text-sm rounded-lg block w-full p-2.5"
							:class="[hasError('question') ? errorInputClass : normalInputClass]"
							type="text"
							v-model="inputs.question"
						>
					</div>

					<p class="text-sm text-red-600 dark:text-red-500"
						v-if="hasError('question')"
					>{{ getError('question') }}</p>
				</div>

				<div class="mb-4">
					<label
						class="block mb-2 text-sm font-medium"
						:class="[hasError('count') ? errorLabelClass : normalLabelClass]"
						for="count"
					>How many choices?</label>

					<div class="mb-2">
						<select
							class="border text-sm rounded-lg block w-full p-2.5"
							:class="[hasError('count') ? errorInputClass : normalInputClass]"
							v-model="inputs.count"
							@change="onCountChange"
						>
							<option v-for="option in countOptions" :value="option">{{ option}}</option>
						</select>
					</div>

					<p class="text-sm text-red-600 dark:text-red-500"
						v-if="hasError('count')"
					>{{ getError('count') }}</p>
				</div>

				<div class="mb-4">
					<label
						class="block mb-2 text-sm font-medium"
						:class="[hasError('choices') ? errorLabelClass : normalLabelClass]"
						for="choices"
					>What are your choices?</label>

					<div class="mb-2" v-for="(choice, i) in inputs.choices">
						<input
							class="border text-sm rounded-lg block w-full p-2.5"
							:class="[hasError(`choices.${i}`) ? errorInputClass : normalInputClass]"
							type="text"
							v-model="inputs.choices[i]" :key="i"
						>

					</div>

					<p class="text-sm text-red-600 dark:text-red-500"
						v-if="hasError('choices')"
					>{{ getError('choices') }}</p>
				</div>

				<div class="flex justify-between mt-8">
					<button disabled
						type="button"
						class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center"
						v-if="submitting.value"
					>
					    <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
					    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
					    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
					    </svg>
					    Loading...
					</button>

					<button
						class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
						type="submit"
						v-else
					>
						Get answer
					</button>

					<button
						class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700"
						type="button"
						@click="newQuestion"
					>New question</button>
				</div>
			</form>
		</div>
	</div>

	<AnswerModal
		ref="answerModal"
		:question="result.question"
		:answer="result.answer"
	/>
</template>
