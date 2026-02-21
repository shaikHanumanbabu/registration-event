document.addEventListener("DOMContentLoaded", function() {
    const customerType = document.getElementById("customer_type");
    const familyIncluded = document.getElementById("family_included");
    const familyCountSection = document.getElementById("familyCountSection");
    const adultsCount = document.getElementById("adults_count");
    const childCount = document.getElementById("child_count");
    const totalAmount = document.getElementById("total_amount");
    const oldCustomerSection = document.getElementById("oldCustomerSection");
    const newMemberMessage = document.getElementById("newMemberMessage");
    const customerIdSection = document.getElementById("customerIdSection");

    // Pricing constants
    const ADULT_PRICE = 500;
    const CHILD_PRICE = 1;

    // Function to calculate total amount based on counts
    function calculateTotalAmount() {
        const adults = parseInt(adultsCount.value) || 0;
        const children = parseInt(childCount.value) || 0;

        const total = adults * ADULT_PRICE;

        // Update the total_amount field
        if (totalAmount) {
            totalAmount.value = total > 0 ? total : "";
        }
    }

    function updateFamilyFields() {
        const type = customerType.value;

        const family = familyIncluded.value;

        if (type == "") return;
        // Show/Hide old customer section based on customer type
        if (type === "new") {
            oldCustomerSection.style.display = "none";
            newMemberMessage.style.display = "block";
            customerIdSection.style.display = "none";
        } else {
            oldCustomerSection.style.display = "block";
            newMemberMessage.style.display = "none";
            customerIdSection.style.display = "block";
        }

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
        childCount.addEventListener("input", function() {
            const value = parseInt(this.value);

            // Validate child count max value is 2
            if (value > 2) {
                alert("Child count must be less than or equal to 2");
                this.value = "";
                calculateTotalAmount();
                return;
            }

            calculateTotalAmount();
        });
    }

    if (customerType && familyIncluded) {
        customerType.addEventListener("change", updateFamilyFields);
        familyIncluded.addEventListener("change", updateFamilyFields);
        updateFamilyFields();
    }

    // Fetch and populate customer data on customer_id blur
    const customerIdInput = document.getElementById("customer_id");
    if (customerIdInput) {
        customerIdInput.addEventListener("blur", function() {
            const regId = customerIdInput.value.trim();
            if (!regId) return;

            fetch(
                    `https://legendbusinessnexus.com/LGNDSCLGRP/LGNDSCLGRP/Admin/Get_Userdatabyregid/${regId}`, {
                        method: "GET",
                        headers: {
                            Authorization: "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vd3d3LmF2bWFydC5jb20vIiwiYXVkIjoiaHR0cDovL3d3dy5hdm1hcnQuY29tLyIsInN1YiI6IkFWTUFSVCBBUGkiLCJpYXQiOjE3NzE2NDg0NDksImV4cCI6MTc3MjAwODQ0OSwicmVnaWQiOiJhZG1pbi1hdm1hcnQiLCJ1c2VydHlwZSI6ImFkbWluIn0.J51JqM_I13PrHxzH6sXI8EltiqDN5oqx5Z_bWjIG7DY",
                        },
                    },
                )
                .then((response) => response.json())
                .then((data) => {
                    // Adjust these keys based on actual API response
                    if (data && data.status && data.status === 1 && data.data) {
                        const user = data.data;
                        document.querySelector('input[name="name"]').value =
                            user[0].name || "";
                        document.querySelector('input[name="phone"]').value =
                            user[0].phone || "";
                        document.querySelector('input[name="email"]').value =
                            user[0].email || "";
                        document.querySelector('input[name="state"]').value =
                            user[0].state || "";
                        document.querySelector('input[name="address"]').value =
                            user[0].address || "";
                    } else {
                        alert("No user found for this Customer ID.");
                    }
                })
                .catch(() => {
                    alert("Failed to fetch customer data.");
                });
        });
    }

    // Find User button logic
    const findUserBtn = document.getElementById("findUserBtn");
    if (findUserBtn && customerIdInput) {
        findUserBtn.addEventListener("click", function() {
            const regId = customerIdInput.value.trim();
            if (!regId) {
                alert("Please enter a Customer Id.");
                return;
            }
            fetch(
                    `https://legendbusinessnexus.com/LGNDSCLGRP/LGNDSCLGRP/Admin/Get_Userdatabyregid/${regId}`, {
                        method: "GET",
                        headers: {
                            Authorization: "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vd3d3LmF2bWFydC5jb20vIiwiYXVkIjoiaHR0cDovL3d3dy5hdm1hcnQuY29tLyIsInN1YiI6IkFWTUFSVCBBUGkiLCJpYXQiOjE3NzE2NDg0NDksImV4cCI6MTc3MjAwODQ0OSwicmVnaWQiOiJhZG1pbi1hdm1hcnQiLCJ1c2VydHlwZSI6ImFkbWluIn0.J51JqM_I13PrHxzH6sXI8EltiqDN5oqx5Z_bWjIG7DY",
                        },
                    },
                )
                .then((response) => response.json())
                .then((data) => {
                    if (data && data.status && data.status === 1 && data.data) {
                        alert("User found.");
                        const user = data.data;
                        document.querySelector('input[name="name"]').value =
                            user.name || "";
                        document.querySelector('input[name="phone"]').value =
                            user.phone || "";
                        document.querySelector('input[name="email"]').value =
                            user.email || "";
                        document.querySelector('input[name="state"]').value =
                            user.state || "";
                        document.querySelector('input[name="address"]').value =
                            user.address || "";
                    } else {
                        alert("No user found for this Customer ID.");
                    }
                })
                .catch(() => {
                    alert("Failed to fetch customer data.");
                });
        });
    }
});