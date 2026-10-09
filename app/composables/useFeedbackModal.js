import { decodeWpText } from "~/utils/decodeWpText";

export const useFeedbackModal = () => {
  const visible = useState("feedback-modal-visible", () => false);
  const item = useState("feedback-modal-item", () => null);
  const session = useState("feedback-modal-session", () => 0);

  const open = (context = null) => {
    session.value += 1;
    item.value = context ? {
      name: decodeWpText(context.name || context.title?.rendered || ""),
      service_id: Number(context.service_id || context.id) || 0,
    } : null;
    visible.value = true;
  };
  const close = () => { visible.value = false; };

  return { visible, item, session, open, close };
};
