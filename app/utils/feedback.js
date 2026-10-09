const byteLength = (value) => new TextEncoder().encode(value).length;

// PALIY validates UTF-8 byte lengths, rather than JavaScript character counts.
export const limitFeedbackText = (value, maxBytes) => {
  let result = "";
  for (const char of String(value || "")) {
    if (byteLength(result + char) > maxBytes) break;
    result += char;
  }
  return result;
};

export const validateFeedback = ({ name, phone, message }) => {
  const errors = {};
  if (!name || byteLength(name) > 100) errors.name = "feedback.invalidName";
  const digits = phone.replace(/\D/g, "");
  if (!/^\+?[\d\s().-]+$/.test(phone) || digits.length < 9 || digits.length > 15) {
    errors.phone = "feedback.invalidPhone";
  }
  if (!message || byteLength(message) > 5000) errors.comment = "feedback.invalidMessage";
  return errors;
};

export const feedbackErrors = {
  paliy_feedback_invalid_name: "feedback.invalidName",
  paliy_feedback_invalid_phone: "feedback.invalidPhone",
  paliy_feedback_invalid_message: "feedback.invalidMessage",
  paliy_feedback_invalid_language: "feedback.unavailableLanguage",
  paliy_feedback_invalid_service: "feedback.unavailableService",
};
