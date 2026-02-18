document.addEventListener("DOMContentLoaded", function() {
    const customerType = document.getElementById("customer_type");
    const familyIncluded = document.getElementById("family_included");
    const familyCountSection = document.getElementById("familyCountSection");
    const adultsCount = document.getElementById("adults_count");
    const childCount = document.getElementById("child_count");
    const totalAmount = document.getElementById("total_amount");

    // Pricing constants
    const ADULT_PRICE = 500;
    const CHILD_PRICE = 300;

    // Function to calculate total amount based on counts
    function calculateTotalAmount() {
        const adults = parseInt(adultsCount.value) || 0;
        const children = parseInt(childCount.value) || 0;

        const total = adults * ADULT_PRICE + children * CHILD_PRICE;

        // Update the total_amount field
        if (totalAmount) {
            totalAmount.value = total > 0 ? total : "";
        }
    }

    function updateFamilyFields() {
        const type = customerType.value;
        const family = familyIncluded.value;

        if (family === "yes" && type === "existing") {
            familyCountSection.style.display = "block";
            adultsCount.required = true;
            childCount.required = true;
        } else if (family === "no" && type === "new") {
            familyCountSection.style.display = "none";
            adultsCount.required = false;
            childCount.required = false;
            adultsCount.value = "";
            childCount.value = "";
            // Clear total amount when family not included
            if (totalAmount) {
                totalAmount.value = "";
            }
        } else if (family === "yes") {
            familyCountSection.style.display = "block";
            adultsCount.required = false;
            childCount.required = false;
        } else {
            familyCountSection.style.display = "none";
            adultsCount.required = false;
            childCount.required = false;
            adultsCount.value = "";
            childCount.value = "";
            // Clear total amount when family not included
            if (totalAmount) {
                totalAmount.value = "";
            }
        }

        // Recalculate total amount when family setting changes
        calculateTotalAmount();
    }

    // Add event listeners for count inputs
    if (adultsCount) {
        adultsCount.addEventListener("input", calculateTotalAmount);
    }

    if (childCount) {
        childCount.addEventListener("input", calculateTotalAmount);
    }

    if (customerType && familyIncluded) {
        customerType.addEventListener("change", updateFamilyFields);
        familyIncluded.addEventListener("change", updateFamilyFields);
        updateFamilyFields();
    }
});