import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['spinner']

    showSpinner() {
        this.spinnerTarget.classList.remove('d-none');
    }
}
