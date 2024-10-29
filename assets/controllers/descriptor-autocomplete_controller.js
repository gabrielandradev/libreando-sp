import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        url: String
    }

    initialize() {
        this._onPreConnect = this._onPreConnect.bind(this);
        this._onConnect = this._onConnect.bind(this);
    }

    connect() {
        this.element.addEventListener('autocomplete:pre-connect', this._onPreConnect);
        this.element.addEventListener('autocomplete:connect', this._onConnect);
    }

    disconnect() {
        // You should always remove listeners when the controller is disconnected to avoid side-effects
        this.element.removeEventListener('autocomplete:connect', this._onConnect);
        this.element.removeEventListener('autocomplete:pre-connect', this._onPreConnect);
    }

    _onPreConnect(event) {
        const url = this.urlValue;
        event.detail.options.create = function (input, callback) {
            const data = new FormData();
            data.append('nombre', input);
            fetch(url, {
                method: 'POST',
                body: data,
            })
                .then(response => response.json())
                .then(data => callback({value: data.id, text: data.nombre}));
        }
    }

    _onConnect(event) {
        // TomSelect has just been initialized and you can access details from the event
    }
}