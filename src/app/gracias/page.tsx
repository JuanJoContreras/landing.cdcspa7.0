'use client';

import { useEffect } from 'react';
import { useRouter } from 'next/navigation';

export default function GraciasPage() {
  const router = useRouter();

  useEffect(() => {
    if (typeof window !== 'undefined' && typeof (window as any).gtag === 'function') {
      (window as any).gtag('event', 'conversion', {
        send_to: 'AW-11099128864/dQU-CPmRno0YEKCIvawp',
      });
    }

    const timer = setTimeout(() => router.push('/'), 5000);
    return () => clearTimeout(timer);
  }, [router]);

  return (
    <main className="min-h-screen flex flex-col items-center justify-center text-center px-6">
      <h1 className="text-3xl font-bold text-[#1A3C5E] mb-4">
        ¡Gracias por contactarnos!
      </h1>
      <p className="text-gray-600 mb-2">
        Recibimos tu solicitud. Te responderemos a la brevedad.
      </p>
      <p className="text-sm text-gray-400">
        Serás redirigido al inicio en unos segundos…
      </p>
    </main>
  );
}
