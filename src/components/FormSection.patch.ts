// ============================================================
// PATCH — FormSection.tsx
// Aplicar los siguientes 3 cambios en el archivo existente:
// ============================================================

// CAMBIO 1 — Agregar import (junto a los imports existentes de Next.js)
import { useRouter } from 'next/navigation';

// CAMBIO 2 — Declarar router dentro del componente (junto a los otros hooks)
const router = useRouter();

// CAMBIO 3 — Reemplazar el bloque de submit exitoso
// ANTES:
//   fireConversionEvents();
//   setStatus('success');
//
// DESPUÉS:
fireConversionEvents();
router.push('/gracias');

// NOTA: El estado 'success' inline ya no es necesario.
// Puedes eliminar el JSX condicional {status === 'success' && ...} si existe.
