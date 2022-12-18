const form = document.getElementById('status_form');
const image = form.elements['mood_selector'];
const submit = document.getElementById("submit");


let valid_text = true;
let valid_mood = true;
let valid_attachement = true

const text = form.elements['publish_query'];
const text_message = document.getElementById('text_message');

text.addEventListener('input', (e)=>{
	if (e.target.value.length>150) 
	{
		text_message.innerHTML="Votre message dépasse 150 caractères..."
		submit.style.visibility='hidden';
		valid_text = false;
	}
	else
	{
		text_message.innerHTML='';
		valid_text = true;
		if (valid_mood == true && valid_attachement == true) 
		{
			submit.style.visibility='visible';
		}
	}
});

const mood = form.elements['mood_query'];
const mood_message = document.getElementById('mood_message');
mood.addEventListener('input', (e)=>{
	if (e.target.value.length>10) 
	{
		mood_message.innerHTML="Votre message dépasse 10 caractères..."
		submit.style.visibility='hidden';
		valid_mood = false;
	}
	else
	{
		mood_message.innerHTML='';
		valid_mood = true;
		if (valid_text == true && valid_attachement == true) 
		{
			submit.style.visibility='visible';
		}
	}
});

const attachement = form.elements['publish_attachement'];
const attachement_message = document.getElementById('attachement_message');
attachement.addEventListener('input', (e)=>{
	if((attachement.files[0].type.includes("image") || attachement.files[0].type.includes("video")) && attachement.files[0].size<=15000000)
	{
		attachement_message.innerHTML='';
		valid_attachement = true;
		if (valid_text == true && valid_mood == true) 
		{
			submit.style.visibility='visible';
		}
	}
	else{
		attachement_message.innerHTML="Le type de fichier ne correspond pas ou le fichier dépasse 15 Mo."
		submit.style.visibility='hidden';
		valid_attachement = false;
	}
});


form.addEventListener('submit', async (event) => {
	event.preventDefault();
	let formData = new FormData();
	formData.append("publish_attachement", attachement.files[0]);
	if(attachement.files[0] != null)
	{
		formData.append("type_attachement", attachement.files[0].type);
	}
	else
	{
		formData.append("type_attachement", "");
	}
	formData.append("publish_query", text.value);
	formData.append("mood_query", mood.value);
	formData.append("mood_selector", image.value);
	await fetch('../handlers/?task=status', { 
		method: "POST", 
		body: formData
	  }); 
	document.getElementById("publish_attachement").value = "";
	text.value = "";
	mood.value = "";
	image.value = "";
});
