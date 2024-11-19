import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["toggleElement"];

    toggleElement(event) {
        let selectedValue = event.target.value;

        const especialidad = document.getElementById("especialidad-selector");

        if (parseInt(selectedValue) > 2) {
            especialidad.classList.remove("d-none");
        } else {
            especialidad.classList.add("d-none");
        }
    }
}