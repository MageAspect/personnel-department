export class ElementBoundingRect {
    constructor(element) {
        this.element = element;
    }

    getOnlyHeight() {
        let elementComputedStyles = getComputedStyle(this.element);

        let paddingY = parseFloat(elementComputedStyles.paddingTop)
            + parseFloat(elementComputedStyles.paddingBottom);

        let borderY = parseFloat(elementComputedStyles.borderTopWidth)
            + parseFloat(elementComputedStyles.borderBottomWidth);

        return this.element.offsetHeight - paddingY - borderY;
    }
}
