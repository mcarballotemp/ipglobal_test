import { Controller } from '@hotwired/stimulus';
import axios from "axios";

export default class extends Controller {
    static targets = ["template", "title"];

    connect() {
        this.loadData();
    }

    loadData() {
        axios.get('/api/blog/posts')
            .then(response => {
                this.renderData(response.data);
            })
            .catch(error => console.error("Error loading Posts data", error));
    }

    renderData(data) {
        data.forEach(item => {
            console.log(this.templateTarget);
            const element = this.templateTarget.content.cloneNode(true);
            console.log('hola2');
            console.log(element);
            console.log('hola');
            console.log(element.querySelector('[data-post-listall-target="title"]'));

            //element.querySelector("[data-post-listall-target='title']").textContent = item.title;

            //this.element.appendChild(document.importNode(element, true));
        });
    }
}
