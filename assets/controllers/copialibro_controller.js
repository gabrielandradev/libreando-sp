import { Controller } from "@hotwired/stimulus"

export default class extends Controller {
    static targets = ["toggleElement"];

    toggleElement(event) {
        let requiereMultiplesCopias = event.target.checked;

        const multiplesCopiasSelector = document.getElementById("copias-selector");

        if (requiereMultiplesCopias) {
            multiplesCopiasSelector.classList.remove("d-none");
        } else {
            multiplesCopiasSelector.classList.add("d-none");
        }
    }
}